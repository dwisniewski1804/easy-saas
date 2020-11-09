<?php

namespace App\Repository;

use App\Domain\Repositories\UserRepositoryInterface;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class UserRepository implements UserRepositoryInterface
{
    public function save(User $user): User
    {
        $user->save();

        return $user;
    }

    public function delete(User $user): void
    {
        $user->delete();
    }

    public function list(array $criteria, int $page, int $perPage): array
    {
        $this->checkIfPageIsNotOutOfRange($page, $perPage);
        /**
         *
         */
        $collection =  DB::table(User::TABLE_NAME)->paginate($perPage, $criteria, 'page', $page);

        return $collection->items();
    }

    public function get(User $user): User
    {
        return $user;
    }

    private function checkIfPageIsNotOutOfRange(int $page, int $perPage): void
    {
        $count = DB::table(User::TABLE_NAME)->count();
        if ($page * $perPage - $perPage > $count) {
            throw new NotFoundHttpException();
        }
    }
}
