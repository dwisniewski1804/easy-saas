<?php

namespace App\Domain\ValueObjects;

use App\Domain\ValueObjects\Validation\PasswordValidator;
use App\Domain\ValueObjects\Exceptions\NotStrongEnoughPasswordException;
use Illuminate\Support\Facades\Hash;

class Password
{
    private string $value;
    private PasswordValidator $validator;

    public function __construct(string $value)
    {
        $this->setValidator($value);
        $this->setValue($value);
    }

    private function setValidator(string $value): void
    {
        $this->validator = new PasswordValidator($value);
    }

    private function setValue(string $value): void
    {
        if (!$this->checkStrength()) {
            throw new NotStrongEnoughPasswordException($this->validator);
        }

        $this->value = $value;
    }

    private function checkStrength(): bool
    {
        $errors = $this->validator->validate();

        return count($errors) === 0;
    }

    public function getEncoded(): string
    {
        return Hash::make($this->value);
    }
}
