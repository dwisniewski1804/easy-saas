<?php

namespace Tests\Feature\Http\Controllers\Admin\User;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Http\Response;
use Tests\TestCase;

class DeleteUserControllerTest extends TestCase
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
    public function testIfItCanDeleteUser(): void
    {
        $count = User::all()->count();
        $response = $this->delete('api/admin/users/2');

        self::assertEquals($count -1, User::all()->count());
        $response->assertStatus(Response::HTTP_OK);
    }

    /**
     * Test if controller action is able to throw NOT_FOUND when user does not exist.
     */
    public function testIfItCanDeleteNotExistingUser(): void
    {
        $response = $this->delete('api/admin/users/5');

        $response->assertStatus(Response::HTTP_NOT_FOUND);
    }
}
