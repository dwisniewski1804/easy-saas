<?php

namespace App\Repository;

use App\Domains\Admin\Models\CreateUserModel;
use App\Models\User;

class UserRepository
{
    public function createUser(CreateUserModel $createUserModel): User
    {
        $user = $createUserModel->transformToModel();
        $user->save();

        return $user;
    }
}
