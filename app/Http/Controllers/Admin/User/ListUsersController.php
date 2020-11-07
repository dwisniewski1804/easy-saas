<?php

namespace App\Http\Controllers\Admin\User;

use App\Domain\Admin\Interactors\UserInteractor;
use App\Domain\ValueObjects\DomainInputBag;
use Illuminate\Http\Request;

class ListUsersController
{

    private UserInteractor $userInteractor;

    public function __construct(UserInteractor $interactor)
    {
        $this->userInteractor = $interactor;
    }

    public function list(Request $request)
    {
        $this->userInteractor->list(new DomainInputBag($request->all()));
    }
}
