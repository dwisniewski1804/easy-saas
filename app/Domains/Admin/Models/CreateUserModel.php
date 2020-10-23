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
     * @throws NotStrongEnoughPasswordException|EmailIsTheSameAsNameException
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

    public function serialize(): ?string
    {
        return serialize($this);
    }

    public function unserialize($serialized)
    {
        unserialize($serialized, []);
    }

    public function transformToModel(): User
    {
        $user = new User();
        $user->setAttribute('email', $this->email);
        $user->setAttribute('name',$this->name);
        $user->setAttribute('password', $this->password->getEncoded());

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
