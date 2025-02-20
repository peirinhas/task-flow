<?php

declare(strict_types=1);

namespace TaskFlow\Core\Task\Domain;

use TaskFlow\Shared\Domain\ValueObject\StringValueObject;

final class TaskDescription extends StringValueObject
{
    public static function create(string $description): self
    {
        return new self($description);
    }
}
