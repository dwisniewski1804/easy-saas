<?php

namespace Tests\Feature;

use App\Models\Enums\UserRolesEnums;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Http\Response;
use Tests\TestCase;

class CreateUserControllerTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * Test if controller action is able to create User entity.
     */
    public function testIfItCanCreateUser(): void
    {
        $response = $this->postJson('api/admin/user', [
            'email' => 'contact@dwisniewski.com',
            'name' => 'dwisniewski',
            'roles' => ['user'],
            'password' => 'Example123@'], [
            'headers' => [
                'Authorization' => 'Bearer abc',
                'Accept' => 'application/json',
            ],]);

        $response->assertStatus(Response::HTTP_CREATED);
        $user = User::all()->last();
        self::assertEquals([UserRolesEnums::ROLE_USER], $user->getAttribute('roles'));
    }

    /**
     * Test if controller action is able to set default (user) role.
     */
    public function testIfItCanCreateDefaultUserRole(): void
    {
        $response = $this->post('api/admin/user', [
            'email' => 'contact@dwisniewski.com',
            'name' => 'dwisniewski',
            'password' => 'Example123#']);

        $response->assertStatus(Response::HTTP_CREATED);
        $user = User::all()->last();
        self::assertEquals([UserRolesEnums::ROLE_USER], $user->getAttribute('roles'));
    }

    /**
     * Test if controller action is able to create User entity.
     */
    public function testIfItGateWillNotLetUsToDoItAsUsualUser(): void
    {
        $adminUser = User::factory()->create(['roles' => ['user']]);
        $this->actingAs($adminUser, 'api');

        $response = $this->postJson('api/admin/user', [
            'email' => 'contact@dwisniewski.com',
            'name' => 'dwisniewski',
            'roles' => ['user'],
            'password' => 'Example123@'], [
            'headers' => [
                'Authorization' => 'Bearer abc',
                'Accept' => 'application/json',
            ],]);

        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /**
     * Test if controller action is able to throw the validation exception from controller
     */
    public function testIfItCanThrowControllerValidationException(): void
    {
        $response = $this->post('api/admin/user', [
            'email' => 'contact@dwisniewski.com',
            'password' => 'Example123']);

        $response->assertStatus(Response::HTTP_BAD_REQUEST);
        $response->assertJsonFragment(["message" => "Validation error"]);
    }

    /**
     * Test if controller action is able to throw an exception from PasswordValidator
     */
    public function testIfItCanThrowPasswordValidationException(): void
    {
        $response = $this->post('api/admin/user', [
            'email' => 'contact@dwisniewski.com',
            'name' => 'dwisniewski1804',
            'password' => 'Example123']);

        $response->assertStatus(Response::HTTP_BAD_REQUEST);
        $response->assertJsonFragment(["message" => "Validation error"]);
    }

    /**
     * Test if controller action is able to throw an exception from PasswordValidator
     */
    public function testIfItCanThrowSameEmailAndNameValidationException(): void
    {
        $response = $this->post('api/admin/user', [
            'email' => 'contact@dwisniewski.com',
            'name' => 'contact@dwisniewski.com',
            'password' => 'Example123#']);

        $response->assertStatus(Response::HTTP_BAD_REQUEST);
        $response->assertJsonFragment(["message" => "Validation error"]);
    }

    /**
     * Test if controller action is able to recognise not unique email
     */
    public function testIfItCanRecognizeIfEmailIsNotUnique(): void
    {
        $existingUser = User::factory()->create();

        $response = $this->post('api/admin/user', [
            'email' => $existingUser->getAttribute('email'),
            'name' => 'contact@dwisniewski.com',
            'password' => 'Example123#']);

        $response->assertStatus(Response::HTTP_BAD_REQUEST);
        $response->assertJsonFragment(["message" => "Validation error"]);
    }
}
