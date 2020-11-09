<?php

namespace App\Http\Controllers\Admin\User;

use App\Domain\Admin\Interactors\UserInteractor;
use App\Domain\ValueObjects\DomainInputBag;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ListUsersController
{
    private UserInteractor $userInteractor;

    public function __construct(UserInteractor $interactor)
    {
        $this->userInteractor = $interactor;
    }

    public function list(Request $request): Response
    {
        try {
            $data = $this->userInteractor->list(new DomainInputBag($request->all()));
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
                    'message' => 'Listing error',
                    'data' => [],
                ],
                Response::HTTP_NOT_FOUND
            );
        }
    }
}
