<?php

namespace App\Domains\Admin\Validators;

use App\Domains\Admin\Models\UserModel;
use Illuminate\Support\MessageBag;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Support\Fluent;

class CreateUserModelValidator implements Validator
{
    private UserModel $value;
    private MessageBag $errors;

    public function __construct(UserModel $value)
    {
        $this->errors = new MessageBag();
        $this->value = $value;
    }

    public function getMessageBag()
    {
        return $this->errors;
    }

    public function validate()
    {
        if ($this->value->getEmail() === $this->value->getName()) {
            $this->errors->add('value', 'Password too short');
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
        $payload = new Fluent($this->value);

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
