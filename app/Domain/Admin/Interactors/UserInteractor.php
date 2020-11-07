<?php

namespace App\Domain\Admin\Interactors;

use App\Domain\DomainInputBagInterface;
use App\Domain\Admin\Entities\UpdateUserEntity;
use App\Domain\Admin\Entities\UserEntity;
use App\Domain\Repositories\UserRepositoryInterface;
use App\Models\User;
use App\Repository\UserRepository;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\ParameterBag;

class UserInteractor
{
    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function list(DomainInputBagInterface $input)
    {
        $this->userRepository;
    }

    public function create(DomainInputBagInterface $input): User
    {
        $model = new UserEntity($input);
        $user = $model->transformToModel();

        return $this->userRepository->save($user);
    }

    public function update(User $user, DomainInputBagInterface $input): User
    {
        $model = new UpdateUserEntity($user, $input);
        $user = $model->transformToModel();

        return $this->userRepository->save($user);
    }

    public function delete(User $user): void
    {
        $this->userRepository->delete($user);
    }
}
