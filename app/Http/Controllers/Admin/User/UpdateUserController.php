<?php


namespace App\Http\Controllers\Admin\User;

use App\Domains\Admin\Services\UserManipulator;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;

class UpdateUserController extends Controller
{
    private UserManipulator $userManipulator;

    private array $rules = [
        'name' => 'required',
        'email' => 'required|email|unique:users',
        'password' => 'required',
    ];

    public function __construct(UserManipulator $creator)
    {
        $this->userManipulator = $creator;
    }

    public function update(User $user, Request $request): Response
    {
        try {
            $this->validate($request, $this->rules);
            $user = $this->userManipulator->update($user, $request);
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
                'message' => 'User has been updated.',
                'data' => ['id' => $user->getAttribute('id')],
            ],
            Response::HTTP_OK
        );
    }
}
