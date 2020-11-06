<?php

namespace App\Domain\Admin\Interactors;

use App\Domain\DomainInputBagInterface;
use App\Domain\Admin\Models\UpdateUserModel;
use App\Domain\Admin\Models\UserModel;
use App\Models\User;
use App\Repository\UserRepository;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\ParameterBag;

class UserInteractor
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @throws ValidationException
     */
    public function create(DomainInputBagInterface $input): User
    {
        $model = new UserModel($input);
        $user = $model->transformToModel();

        return $this->userRepository->save($user);
    }

    public function update(User $user, DomainInputBagInterface $input): User
    {
        $model = new UpdateUserModel($user, $input);
        $user = $model->transformToModel();

        return $this->userRepository->save($user);
    }

    public function delete(User $user): void
    {
        $this->userRepository->delete($user);
    }
}
