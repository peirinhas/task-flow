<?php

declare(strict_types=1);

namespace TaskFlow\Core\User\Domain;

use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use TaskFlow\Shared\Domain\Aggregate\AggregateRoot;
use TaskFlow\Shared\Domain\Uuid;

final class User extends AggregateRoot implements UserInterface, PasswordAuthenticatedUserInterface
{
    public function __construct(
        private readonly Uuid $id,
        private readonly UserName $name,
        private readonly UserEmailAddress $email,
        private UserPassword $password,
        private readonly UserCreatedAt $createdAt,
    ) {
    }

    public static function create(
        Uuid $id,
        UserName $name,
        UserEmailAddress $email,
        UserPassword $password,
    ): self {
        return new self(
            id: $id,
            name: $name,
            email: $email,
            password: $password,
            createdAt: UserCreatedAt::createNow(),
        );
    }

    public function id(): Uuid
    {
        return $this->id;
    }

    public function name(): UserName
    {
        return $this->name;
    }

    public function changePassword(UserPassword $password): void
    {
        $this->password = $password;
    }

    public function getPassword(): ?string
    {
        return $this->password->value();
    }

    public function getRoles(): array
    {
        $roles[] = 'ROLE_USER';
        return array_unique($roles);
    }

    public function eraseCredentials()
    {
    }

    public function getUserIdentifier(): string
    {
        return $this->email->value();
    }
}
