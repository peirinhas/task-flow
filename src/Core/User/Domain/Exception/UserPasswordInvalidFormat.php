<?php

declare(strict_types=1);

namespace TaskFlow\Core\User\Domain\Exception;

use TaskFlow\Shared\Domain\Exception\UnexpectedValueException;

final class UserPasswordInvalidFormat extends UnexpectedValueException
{
    public static function create(string $password, int $min_length): self
    {
        return new self(
            "Invalid password format <$password>. It must contain at least one uppercase letter, 
            one lowercase letter, and one number, and be at least $min_length characters long.",
            'user_password.invalid',
        );
    }
}
