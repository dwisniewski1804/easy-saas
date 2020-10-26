<?php

namespace App\Security\Policies;

use App\Models\User;

class UserPolicy
{
    public function create(User $userLoggedIn)
    {
        return $userLoggedIn->isSuperAdmin();
    }

    public function update(User $userLoggedIn, User $editedUser)
    {
        return $editedUser === $userLoggedIn || $userLoggedIn->isSuperAdmin();
    }
}
