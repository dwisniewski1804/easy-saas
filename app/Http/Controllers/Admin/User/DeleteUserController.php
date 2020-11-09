<?php

namespace App\Http\Controllers\Admin\User;

use App\Domain\Admin\Interactors\UserInteractor;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class DeleteUserController
{
    private UserInteractor $userInteractor;

    public function __construct(UserInteractor $interactor)
    {
        $this->userInteractor = $interactor;
    }

    public function delete(User $user): Response
    {
        try {
            $this->userInteractor->delete($user);
        } catch (\Exception  $exception) {
            return new JsonResponse(
                [
                    'message' => 'Deleting error',
                    'data' => ['errors' => $exception->getMessage()],
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
