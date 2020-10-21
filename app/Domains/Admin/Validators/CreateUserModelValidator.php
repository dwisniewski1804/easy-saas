<?php

namespace App\Domains\Admin\Validators;

use App\Domains\Admin\Models\CreateUserModel;
use Illuminate\Contracts\Support\MessageBag;
use Illuminate\Contracts\Validation\Validator;

class CreateUserModelValidator implements Validator
{
    private CreateUserModel $value;
    private MessageBag $errors;

    public function __construct(CreateUserModel $value)
    {
        $this->errors = new \Illuminate\Support\MessageBag();
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
        // TODO: Implement sometimes() method.
    }

    public function after($callback)
    {
        // TODO: Implement after() method.
    }

    public function errors(): MessageBag
    {
        return $this->errors;
    }
}
