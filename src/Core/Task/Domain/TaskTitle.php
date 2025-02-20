<?php

declare(strict_types=1);

namespace TaskFlow\Core\Task\Domain;

use TaskFlow\Shared\Domain\ValueObject\StringValueObject;

final class TaskTitle extends StringValueObject
{
    public static function create(string $title): self
    {
        return new self($title);
    }
}
