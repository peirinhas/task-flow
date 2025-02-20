<?php

declare(strict_types=1);

namespace TaskFlow\Core\User\Domain\Exception;

use TaskFlow\Core\User\Domain\User;
use TaskFlow\Shared\Domain\Exception\DuplicatedException;
use TaskFlow\Shared\Domain\Uuid;

class UserAlreadyExists extends DuplicatedException
{
    public static function create(Uuid $id): self
    {
        return new self(
            self::alreadyExistsMessage(User::class, "id <$id>"),
            'user.already_exists',
        );
    }
}
