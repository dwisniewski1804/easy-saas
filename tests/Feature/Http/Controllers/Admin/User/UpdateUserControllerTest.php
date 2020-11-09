<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Http\Response;
use Tests\TestCase;

class UpdateUserControllerTest extends TestCase
{
    use DatabaseMigrations;

    protected function setUp(): void
    {
        parent::setUp();
        User::factory()->create(['roles' => ['user']]);
    }

    /**
     * Test if controller action is able to create User entity.
     */
    public function testIfItCanUpdateUsername(): void
    {
        $updatedName = 'test';
        $response = $this->put('api/admin/users/2', [
            'email' => 'contact@dwisniewski.com',
            'name' => $updatedName,
            'password' => 'Example123@']);

        self::assertEquals($updatedName, User::all()->last()->name);
        $response->assertStatus(Response::HTTP_OK);
    }

    /**
     * Test if controller action is able to throw NOT_FOUND when user does not exist.
     */
    public function testIfItCanDeleteNotExistingUser(): void
    {
        $response = $this->put('api/admin/users/5');

        $response->assertStatus(Response::HTTP_NOT_FOUND);
    }
}
