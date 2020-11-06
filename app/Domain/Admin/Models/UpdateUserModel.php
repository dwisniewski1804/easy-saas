<?php

namespace App\Domain\Admin\Models;

use App\Domain\DomainInputBagInterface;
use App\Models\User;

class UpdateUserModel extends UserModel
{
    public function __construct(User $user, DomainInputBagInterface $input)
    {
        parent::__construct($input);
        $this->setUserEntity($user);
    }
}
