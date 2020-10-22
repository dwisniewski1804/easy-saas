<?php

namespace App\Domains\Admin\Validators;

use App\Domains\Admin\Models\CreateUserModel;
use Illuminate\Contracts\Support\MessageBag;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Support\Fluent;
use Illuminate\Support\MessageBag as MessageBagConcrete;

class CreateUserModelValidator implements Validator
{
    private CreateUserModel $value;
    private MessageBag $errors;

    public function __construct(CreateUserModel $value)
    {
        $this->errors = new MessageBagConcrete();
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
