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
                'roles' => [UserRolesEnums::ALL_ROLES[array_rand(UserRolesEnums::ALL_ROLES, 1)]]]);
        }
    }

    /**
     * Test if controller action is able to list users by default page.
     */
    public function testIfItCanListDefaultPageWithDefaultPerPageValue(): void
    {
        $response = $this->get('api/admin/users');

        $jsonContent = json_decode($response->getContent(), true);
        $this->assertCount(6, $jsonContent['data']['data']);
        $this->assertEquals(1, $jsonContent['data']['current_page']);

        $response->assertStatus(Response::HTTP_OK);
    }

    /**
     * Test if controller action is able to list users by page.
     */
    public function testIfItCanList2ndPageWith2records(): void
    {
        $response = $this->get('api/admin/users?page=2&perPage=2');
        /**
         * @var string $content
         */
        $content = $response->getContent();

        if ($content) {
            $jsonContent = json_decode($response->getContent(), true);

            self::assertCount(2, $jsonContent['data']['data']);
            self::assertEquals(2, $jsonContent['data']['current_page']);

            $response->assertStatus(Response::HTTP_OK);
        }
    }

    /**
     * Test if controller action is able to create User entity.
     */
    public function testIfItCanThrow404OnPageOutOfRange(): void
    {
        $response = $this->get('api/admin/users?page=10&perPage=2');

        $response->assertStatus(Response::HTTP_NOT_FOUND);
    }
}
