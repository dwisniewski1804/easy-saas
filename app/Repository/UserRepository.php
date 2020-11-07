<?php

namespace App\Repository;

use App\Domain\Repositories\UserRepositoryInterface;
use App\Models\User;

class UserRepository implements UserRepositoryInterface
{
    public function save(User $user): User
    {
        $user->save();

        return $user;
    }

    public function delete(User $user): void
    {
        // TODO check if it can be deleted or not
        $user->delete();
    }
}
