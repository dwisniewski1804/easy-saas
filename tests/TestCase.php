<?php

namespace Tests;

use App\Models\Enums\UserRolesEnums;
use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function setUp(): void
    {
        parent::setUp();
        $adminUser = User::factory()->create(['roles' => [UserRolesEnums::ROLE_SUPER_ADMIN]]);
        $this->actingAs($adminUser, 'api');
    }
}
