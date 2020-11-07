<?php

namespace Tests\Feature\Http\Controllers\Admin\User;

use App\Models\Enums\UserRolesEnums;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Http\Response;
use Tests\TestCase;

class ListUsersControllerTest extends TestCase
{
    use DatabaseMigrations;

    protected function setUp(): void
    {
        parent::setUp();
        for ($i=0; $i<5; $i++) {
            User::factory()->create([
                'roles' => UserRolesEnums::ALL_ROLES[array_rand(UserRolesEnums::ALL_ROLES, 1)]]);
        }
    }

    /**
     * Test if controller action is able to create User entity.
     */
    public function testIfItCanList2ndPageWith2records(): void
    {
        $response = $this->get('api/admin/users?page=2?limit=2');

        $response->assertStatus(Response::HTTP_OK);
    }
}
