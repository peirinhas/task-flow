<?php

declare(strict_types=1);

namespace TaskFlow\Core\User\Infrastructure\Security;

use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use TaskFlow\Core\User\Domain\User;
use TaskFlow\Core\User\Domain\UserPassword;

class PasswordHasher
{
    public function __construct(private readonly UserPasswordHasherInterface $passwordHasher)
    {
    }

    public function hashPassword(User $user, UserPassword $password): string
    {
        return $this->passwordHasher->hashPassword($user, $password->value());
    }
}
