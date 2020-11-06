<?php

namespace App\Domain\Admin\Models;

interface ValidatableInterface
{
    public function validate(): void;
}
