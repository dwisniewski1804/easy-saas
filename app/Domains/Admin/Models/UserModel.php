<?php

namespace App\Domains\Admin\Models;

use App\Domains\Admin\Exceptions\EmailIsTheSameAsNameException;
use App\Domains\Admin\Validators\CreateUserModelValidator;
use App\Exceptions\ValueObjects\NotStrongEnoughPasswordException;
use App\Models\Enums\UserRolesEnums;
use App\Models\User;
use App\Models\ValueObjects\Password;
use Illuminate\Http\Request;

class UserModel implements \Serializable, ValidatableInterface, TransformableToModelInterface
{
    protected string $email;
    protected string $name;
    protected array $roles;
    protected Password $password;
    protected CreateUserModelValidator $validator;
    protected User $userEntity;

    /**
     * CreateUserModel constructor.
     * @throws NotStrongEnoughPasswordException|EmailIsTheSameAsNameException
     */
    public function __construct(Request $request)
    {
        $this->setUserEntity();
        $this->validator = new CreateUserModelValidator($this);
        $this->createFromRequest($request);
        $this->validate();
    }

    protected function setUserEntity()
    {
        $this->userEntity = new User;
    }

    /**
     * @throws NotStrongEnoughPasswordException
     */
    protected function createFromRequest(Request $request): void
    {
        $this->email = $request->get('email');
        $this->name = $request->get('name');
        $this->roles = $request->get('roles') ?? [UserRolesEnums::ROLE_USER];
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
        $this->userEntity->setAttribute('email', $this->email);
        $this->userEntity->setAttribute('name', $this->name);
        $this->userEntity->setAttribute('password', $this->password->getEncoded());
        $this->userEntity->setAttribute('roles', $this->roles);

        return $this->userEntity;
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

    /**
     * @return array
     */
    public function getRoles(): array
    {
        return $this->roles;
    }
}
