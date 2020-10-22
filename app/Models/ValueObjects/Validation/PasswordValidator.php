<?php

namespace App\Models\ValueObjects\Validation;

use Illuminate\Contracts\Support\MessageBag;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Support\MessageBag as MessageBagConcrete;

class PasswordValidator implements Validator
{
    private string $value;
    private MessageBag $errors;

    private const ERROR_MESSAGE = 'Password has to have: at least one lowercase letter *'.
                                  ' at least one uppercase letter * at least one number *'.
                                  ' at least one special character * total length between 8 and 16';
    public function __construct(string $value)
    {
        $this->errors = new MessageBagConcrete();
        $this->value = $value;
    }

    public function getMessageBag()
    {
        // TODO: Implement getMessageBag() method.
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

    public function validated()
    {
        // TODO: Implement validated() method.
    }

    public function fails()
    {
        // TODO: Implement fails() method.
    }

    public function failed()
    {
        // TODO: Implement failed() method.
    }

    public function sometimes($attribute, $rules, callable $callback)
    {
        $payload = new Fluent($this->value);

        if ($callback($payload)) {
            foreach ((array) $attribute as $key) {
                $this->errors->add($key, $rules);
            }
        }

        return $this;
    }

    public function after($callback)
    {
        $callback();
        return $this;
    }

    public function errors(): MessageBag
    {
        return $this->errors;
    }
}
