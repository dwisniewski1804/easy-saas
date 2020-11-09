<?php


namespace App\Http\Controllers\Admin\User;

use App\Domain\Admin\Interactors\UserInteractor;
use App\Domain\ValueObjects\DomainInputBag;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;

class UpdateUserController extends Controller
{
    private UserInteractor $useruserInteractor;

    private array $rules = [
        'name' => 'required',
        'email' => 'required|email|unique:users',
        'password' => 'required',
    ];

    public function __construct(UserInteractor $creator)
    {
        $this->useruserInteractor = $creator;
    }

    public function update(User $user, Request $request): Response
    {
        try {
            $this->validate($request, $this->rules);
            $user = $this->useruserInteractor->update($user, new DomainInputBag($request->toArray()));
        } catch (ValidationException  $exception) {
            return new JsonResponse(
                [
                    'message' => 'Validation error',
                    'data' => ['errors' => $exception->errors()],
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
