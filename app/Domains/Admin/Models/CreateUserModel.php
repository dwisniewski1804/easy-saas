<?php

namespace App\Domains\Admin\Models;

use App\Domains\Admin\Exceptions\EmailIsTheSameAsNameException;
use App\Domains\Admin\Validators\CreateUserModelValidator;
use App\Exceptions\ValueObjects\NotStrongEnoughPasswordException;
use App\Models\User;
use App\Models\ValueObjects\Password;
use Illuminate\Http\Request;



class CreateUserModel implements \Serializable, ValidatableInterface, TransformableToModelInterface
{
    private string $email;
    private string $name;

    private Password $password;
    private CreateUserModelValidator $validator;

    /**
     * CreateUserModel constructor.
     * @throws NotStrongEnoughPasswordException
     */
    public function __construct(Request $request)
    {
        $this->validator = new CreateUserModelValidator($this);
        $this->createFromRequest($request);
        $this->validate();
    }

    /**
     * @throws NotStrongEnoughPasswordException
     */
    private function createFromRequest(Request $request): void
    {
        $this->email = $request->get('email');
        $this->name = $request->get('name');
        $this->password = new Password($request->get('password'));
    }

    public function validate(): void
    {
        if (count($this->validator->validate())) {
            throw new EmailIsTheSameAsNameException($this->validator);
        }
    }

    public function serialize()
    {
        // TODO: Implement serialize() method.
    }

    public function unserialize($serialized)
    {
        // TODO: Implement unserialize() method.
    }

    public function transformToModel(): User
    {
        $user = new User();
        $user->email = $this->email;
        $user->name = $this->name;
        $user->password = $this->password->getEncoded();

        return $user;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPassword(): Password
    {
        return $this->password;
    }
}
