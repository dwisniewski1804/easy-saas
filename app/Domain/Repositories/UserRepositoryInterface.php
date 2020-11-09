<?php

namespace App\Domain\Repositories;

use App\Models\User;

interface UserRepositoryInterface
{
    public function save(User $user);
    public function delete(User $user);
    public function list(array $criteria, int $page, int $perPage);
    public function get(User $user): User;
}
