<?php

declare(strict_types=1);

namespace TaskFlow\Core\User\Domain;

use TaskFlow\Shared\Domain\ValueObject\StringValueObject;

final class UserName extends StringValueObject
{
    public static function create(string $name): self
    {
        return new self($name);
    }
}
