<?php

namespace App\Http\Controllers\Admin\User;

use App\Domain\Admin\Interactors\UserInteractor;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ShowUserController
{
    private UserInteractor $userInteractor;

    public function __construct(UserInteractor $interactor)
    {
        $this->userInteractor = $interactor;
    }

    public function show(User $user): Response
    {
        try {
            $data = $this->userInteractor->show($user);
            return new JsonResponse(
                [
                    'message' => 'OK',
                    'data' => $data,
                ],
                Response::HTTP_OK
            );
        } catch (\Exception $exception) {
            return new JsonResponse(
                [
                    'message' => 'Not found',
                    'data' => null,
                ],
                Response::HTTP_NOT_FOUND
            );
        }
    }
}
