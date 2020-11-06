<?php

namespace App\Http\Controllers\Admin\User;

use App\Domain\Admin\Interactors\UserInteractor;
use App\Domain\ValueObjects\DomainInputBag;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;

class CreateUserController extends Controller
{
    private UserInteractor $userInteractor;

    private array $rules = [
        'name' => 'required',
        'email' => 'required|email|unique:users',
        'password' => 'required',
    ];

    public function __construct(UserInteractor $interactor)
    {
        $this->userInteractor = $interactor;
    }

    public function create(Request $request): Response
    {
        try {
            $this->validate($request, $this->rules);
            $user = $this->userInteractor->create(new DomainInputBag($request->toArray()));
        } catch (ValidationException  $e) {
            return new JsonResponse(
                [
                    'message' => 'Validation error',
                    'data' => ['errors' => $e->errors()],
                ],
                Response::HTTP_BAD_REQUEST
            );
        }

        return new JsonResponse(
            [
                'message' => 'User has been created.',
                'data' => ['id' => $user->getAttribute('id')],
            ],
            Response::HTTP_CREATED
        );
    }
}
