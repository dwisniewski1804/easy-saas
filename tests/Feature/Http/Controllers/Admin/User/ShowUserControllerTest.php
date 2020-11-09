<?php

namespace Tests\Feature\Http\Controllers\Admin\User;

use App\Models\Enums\UserRolesEnums;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Http\Response;
use Tests\TestCase;

class ShowUserControllerTest extends TestCase
{
    use DatabaseMigrations;

    protected function setUp(): void
    {
        parent::setUp();
        for ($i=0; $i<5; $i++) {
            User::factory()->create([
                'roles' => [UserRolesEnums::ROLE_USER]]);
        }
    }

    /**
     * Test if controller action is able to show User entity.
     */
    public function testIfItCanSHowOneRecord(): void
    {
        $response = $this->get('api/admin/users/3');

        $jsonContent = json_decode($response->getContent(), true);

        self::assertArrayHasKey('id', $jsonContent['data']);
        $response->assertStatus(Response::HTTP_OK);
    }

    /**
     * Test if controller action is able throw 404 on not-existing user
     */
    public function testIfItCanThrow404OnNotExistingUser(): void
    {
        $response = $this->get('api/admin/users/13');

        $response->assertStatus(Response::HTTP_NOT_FOUND);
    }
}
