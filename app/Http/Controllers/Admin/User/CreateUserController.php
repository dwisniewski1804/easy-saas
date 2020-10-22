<?php

namespace App\Http\Controllers\Admin\User;

use App\Domains\Admin\Services\UserCreator;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;

class CreateUserController extends Controller
{
    private UserCreator $userCreator;

    private array $rules = [
        'name' => 'required',
        'email' => 'required|email|unique:users',
        'password' => 'required',
    ];

    public function __construct(UserCreator $creator)
    {
        $this->userCreator = $creator;
    }

    public function create(Request $request)
    {
        try {
            $this->validate($request, $this->rules);
            $user = $this->userCreator->create($request);
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
                'data' => ['id' => $user->id],
            ]
        );
    }
}
