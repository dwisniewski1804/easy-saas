<?php

namespace App\Domain\Admin\Entities;

interface ValidatableInterface
{
    public function validate(): void;
}
