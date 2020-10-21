<?php

namespace App\Domains\Admin\Models;

interface ValidatableInterface
{
    public function validate(): void;
}
