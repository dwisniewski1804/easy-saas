<?php

namespace Tests\Feature;

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
        $this->withoutExceptionHandling();
        $this->post('admin/user', [
            'email' => 'contact@dwisniewski.com',
            'name' => 'dwisniewski',
            'password' => 'Example123@']);

        $count = User::all()->count();
        self::assertEquals(1, $count);
    }

    /**
     * Test if controller action is able to throw the validation exception from controller
     */
    public function testIfItCanThrowControllerValidationException(): void
    {
        $response = $this->post('admin/user', [
            'email' => 'contact@dwisniewski.com',
            'password' => 'Example123']);

        $response->assertStatus(Response::HTTP_BAD_REQUEST);
    }

    /**
     * Test if controller action is able to throw an exception from PasswordValidator
     */
    public function testIfItCanThrowPasswordValidationException(): void
    {
        $response = $this->post('admin/user', [
            'email' => 'contact@dwisniewski.com',
            'name' => 'dwisniewski1804',
            'password' => 'Example123']);

        $response->assertStatus(Response::HTTP_BAD_REQUEST);
    }

    /**
     * Test if controller action is able to throw an exception from PasswordValidator
     */
    public function testIfItCanThrowSameEmailAndNameValidationException(): void
    {
        $response = $this->post('admin/user', [
            'email' => 'contact@dwisniewski.com',
            'name' => 'contact@dwisniewski.com',
            'password' => 'Example123#']);

        $response->assertStatus(Response::HTTP_BAD_REQUEST);
    }
}
