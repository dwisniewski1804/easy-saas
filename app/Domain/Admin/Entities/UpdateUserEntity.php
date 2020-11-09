<?php

namespace App\Domain\Admin\Entities;

use App\Domain\DomainInputBagInterface;
use App\Models\User;

class UpdateUserEntity extends UserEntity
{
    public function __construct(User $user, DomainInputBagInterface $input)
    {
        parent::__construct($input);
        $this->setUserEntity($user);
    }
}
