<?php

namespace App\Http\Controllers\Admin\User;

use App\Domains\Admin\Services\UserManipulator;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class DeleteUserController
{
    private UserManipulator $userManipulator;

    public function __construct(UserManipulator $creator)
    {
        $this->userManipulator = $creator;
    }

    public function delete(User $user)
    {
        try {
            $this->userManipulator->delete($user);
        } catch (\Exception  $e) {
            return new JsonResponse(
                [
                    'message' => 'Deleting error',
                    'data' => ['errors' => $e->getMessage()],
                ],
                Response::HTTP_BAD_REQUEST
            );
        }

        return new JsonResponse(
            [
                'message' => 'User has been updated.',
                'data' => ['id' => $user->getAttribute('id')],
            ],
            Response::HTTP_OK
        );
    }
}
