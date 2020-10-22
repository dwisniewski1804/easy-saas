<?php

namespace App\Models\ValueObjects\Validation;

use Illuminate\Contracts\Support\MessageBag;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Support\Fluent;
use Illuminate\Support\MessageBag as MessageBagConcrete;

class PasswordValidator implements Validator
{
    private const MINIMUM_LENGTH = 8;
    private string $value;
    private MessageBag $errors;

    public function __construct(string $value)
    {
        $this->errors = new MessageBagConcrete();
        $this->value = $value;
    }

    public function getMessageBag()
    {
        // TODO: Implement getMessageBag() method.
    }

    public function validate()
    {
        if (strlen($this->value) < self::MINIMUM_LENGTH) {
            $this->errors->add('value', 'Password too short');
        }

        if (!preg_match('#[0-9]+#', $this->value)) {
            $this->errors->add('value', 'Password must include at least one number');
        }

        if (!preg_match('#[a-zA-Z]+#', $this->value)) {
            $this->errors->add('value', 'Password must include at least one letter');
        }

        if (!preg_match('/[\'\/~`\!@#\$%\^&\*\(\)_\-\+=\{\}\[\]\|;:"\<\>,\.\?\\\]/', $this->value)) {
            $this->errors->add('value', 'Password must include at least one special character');
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
        // TODO: Implement errors() method.
    }
}
