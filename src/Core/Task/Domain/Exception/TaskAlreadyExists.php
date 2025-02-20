<?php

declare(strict_types=1);

namespace TaskFlow\Core\Task\Domain\Exception;

use TaskFlow\Core\Task\Domain\Task;
use TaskFlow\Shared\Domain\Exception\DuplicatedException;
use TaskFlow\Shared\Domain\Uuid;

class TaskAlreadyExists extends DuplicatedException
{
    public static function create(Uuid $id): self
    {
        return new self(
            self::alreadyExistsMessage(Task::class, "id <$id>"),
            'task.already_exists',
        );
    }
}
