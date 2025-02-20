<?php

declare(strict_types=1);

namespace TaskFlow\Core\User\Domain\Exception;

use TaskFlow\Core\User\Domain\User;
use TaskFlow\Shared\Domain\Exception\DuplicatedException;

final class UserEmailAlreadyExists extends DuplicatedException
{
    public static function create(string $email): self
    {
        return new self(
            self::alreadyExistsMessage(User::class, "email <$email>"),
            'user.email_already_exists',
        );
    }
}
