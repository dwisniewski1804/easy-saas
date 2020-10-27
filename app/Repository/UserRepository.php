<?php

namespace App\Repository;

use App\Models\User;

class UserRepository
{
    public function save(User $user): User
    {
        $user->save();

        return $user;
    }

    public function delete(User $user)
    {
        // TODO check if it can be deleted or not
        $user->delete();
    }
}
