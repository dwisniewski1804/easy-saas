<?php

namespace App\Domains\Admin\Services;

use App\Domains\Admin\Models\CreateUserModel;
use App\Models\User;
use App\Repository\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class UserCreator
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
        $model = new CreateUserModel($request);

        return $this->userRepository->createUser($model);
    }
}
