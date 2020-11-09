<?php

namespace App\Security\Policies;

use App\Models\User;

class UserPolicy
{
    public function create(User $userLoggedIn): bool
    {
        return $userLoggedIn->isSuperAdmin();
    }

    public function update(User $userLoggedIn, User $editedUser): bool
    {
        return $editedUser === $userLoggedIn || $userLoggedIn->isSuperAdmin();
    }

    public function delete(User $userLoggedIn): bool
    {
        return $userLoggedIn->isSuperAdmin();
    }

    public function list(User $userLoggedIn): bool
    {
        return $userLoggedIn->isSuperAdmin();
    }

    public function show(User $userLoggedIn, User $editedUser): bool
    {
        dump($editedUser);
        return $userLoggedIn->isSuperAdmin() && !$editedUser->isSuperAdmin();
    }
}
