<?php

namespace App\Domain\Admin\Entities;

use App\Domain\DomainInputBagInterface;
use App\Domain\ValueObjects\Password;
use App\Domain\Admin\Exceptions\EmailIsTheSameAsNameException;
use App\Domain\Admin\Validators\CreateUserModelValidator;
use App\Models\Enums\UserRolesEnums;
use App\Models\User;

class UserEntity implements \Serializable, ValidatableInterface, TransformableToModelInterface
{
    protected string $email;
    protected string $name;
    protected array $roles;
    protected Password $password;
    protected CreateUserModelValidator $validator;
    protected User $userEntity;

    /**
     * CreateUserModel constructor.
     * @throws EmailIsTheSameAsNameException
     */
    public function __construct(DomainInputBagInterface $input)
    {
        $this->setUserEntity();
        $this->validator = new CreateUserModelValidator($this);
        $this->createFromRequest($input);
        $this->validate();
    }

    protected function setUserEntity(User $user = null): void
    {
        if ($user) {
            $this->userEntity = $user;
            return;
        }

        $this->userEntity = new User;
    }

    protected function createFromRequest(DomainInputBagInterface $request): void
    {
        $this->email = (string) $request->get('email');
        $this->name = (string) $request->get('name');
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

    public function unserialize($serialized): array
    {
        return unserialize($serialized, []);
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

    public function getRoles(): array
    {
        return $this->roles;
    }
}
