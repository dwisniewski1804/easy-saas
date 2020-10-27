<?php

namespace App\Domains\Admin\Models;

use App\Models\User;
use Illuminate\Http\Request;

class UpdateUserModel extends UserModel
{
    public function __construct(User $user, Request $request)
    {
        parent::__construct($request);
        $this->setUserEntity($user);
    }
}
