<?php

namespace App\Domains\Admin\Services;

use App\Domains\Admin\Models\UpdateUserModel;
use App\Domains\Admin\Models\UserModel;
use App\Models\User;
use App\Repository\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class UserManipulator
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @throws ValidationException
     */
    public function create(Request $request): User
    {
        $model = new UserModel($request);
        $user = $model->transformToModel();

        return $this->userRepository->save($user);
    }

    public function update(User $user, Request $request): User
    {
        $model = new UpdateUserModel($user, $request);
        $user = $model->transformToModel();

        return $this->userRepository->save($user);
    }
}
