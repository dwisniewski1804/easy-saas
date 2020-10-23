<?php

namespace App\Models\ValueObjects\Validation;

use Illuminate\Support\MessageBag;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Support\Fluent;

class PasswordValidator implements Validator
{
    private string $value;
    private MessageBag $errors;

    private const ERROR_MESSAGE = 'Password has to have: at least one lowercase letter *'.
                                  ' at least one uppercase letter * at least one number *'.
                                  ' at least one special character * total length between 8 and 16';
    public function __construct(string $value)
    {
        $this->errors = new MessageBag();
        $this->value = $value;
    }

    public function getMessageBag()
    {
        return $this->errors;
    }

    public function validate(): array
    {
        /**
         * ^                 --> start of string
         * (?=.*[a-z])       --> at least one lowercase letter
         * (?=.*[A-Z])       --> at least one uppercase letter
         * (?=.*[0-9)        --> at least one number
         * (?=.*[!@#$%^&*-]) --> at least one special character
         * {8,20}            --> total length between 8 and 20
         * $                 --> end of string
         */
        if (!preg_match('/^(?=.*[!@#$%^&*-])(?=.*[0-9])(?=.*[A-Z])(?=.*[a-z]).{8,20}$/', $this->value)) {
            $this->errors->add('password', self::ERROR_MESSAGE);
        }

        return $this->errors->toArray();
    }

    public function validated(): array
    {
        return [];
    }

    public function fails(): bool
    {
        return $this->errors->count() !== 0;
    }

    public function failed()
    {
        return [];
    }

    public function sometimes($attribute, $rules, callable $callback)
    {
        $payload = new Fluent([$this->value]);

        if ($callback($payload)) {
            foreach ((array) $attribute as $key) {
                $this->errors->add($key, is_array($rules) ? implode(',', $rules) : $rules);
            }
        }

        return $this;
    }

    public function after($callback)
    {
        $callback = null;

        return $this;
    }

    public function errors(): MessageBag
    {
        return $this->errors;
    }
}
