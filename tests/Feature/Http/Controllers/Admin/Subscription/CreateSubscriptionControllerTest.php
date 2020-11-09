<?php

namespace Http\Controllers\Subscription;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class CreateSubscriptionControllerTest extends TestCase
{
    use DatabaseMigrations;

//    /**
//     * Test if controller action is able to create User entity.
//     */
//    public function IfItCanCreateSubscription(): void
//    {
//        $this->withoutExceptionHandling();
//        $response = $this->postJson('api/admin/subscription', [
//            'clientId' => 1,
//            'offerId' => 1,
//            'startedAt' => new \DateTime(),
//            'expiresAt' => new \DateTime(),
//        ]);
//
//        $response->assertStatus(Response::HTTP_CREATED);
//        $user = User::all()->last();
//        self::assertEquals([UserRolesEnums::ROLE_USER], $user->getAttribute('roles'));
//    }
}
