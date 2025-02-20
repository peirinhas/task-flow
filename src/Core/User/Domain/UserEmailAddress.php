<?php

declare(strict_types=1);

namespace TaskFlow\Core\User\Domain;

use TaskFlow\Shared\Domain\ValueObject\EmailAddress;

final class UserEmailAddress extends EmailAddress
{
    public static function create(string $email): self
    {
        return new self($email);
    }
}
