<?php

namespace App\Domain\Repositories;

use App\Models\User;

interface UserRepositoryInterface
{
    public function save(User $user): User;
    public function delete(User $user): void;
    public function list(array $criteria, int $page, int $perPage): array;
    public function get(User $user): User;
}
