<?php

namespace App\Domain\Admin\Interactors;

use App\Domain\Admin\Entities\UpdateUserEntity;
use App\Domain\Admin\Entities\UserEntity;
use App\Domain\DomainInputBagInterface;
use App\Domain\Repositories\UserRepositoryInterface;
use App\Models\User;

class UserInteractor
{
    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function list(DomainInputBagInterface $input): array
    {
        return $this->userRepository->list(
            $input->get('criteria') ?? ['*'],
            (int)($input->get('page') ?? 1),
            (int)($input->get('perPage') ?? 10)
        );
    }

    public function show(User $user): User
    {
        return $this->userRepository->get($user);
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
