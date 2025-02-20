<?php

declare(strict_types=1);

namespace TaskFlow\Core\Task\Domain\Exception;

use TaskFlow\Core\Task\Domain\Task;
use TaskFlow\Shared\Domain\Exception\NotFoundException;
use TaskFlow\Shared\Domain\Uuid;

final class TaskNotFound extends NotFoundException
{
    public static function byId(Uuid $id): self
    {
        return new self(
            self::notFoundMessage(Task::class, "id <$id>"),
            'task.not_found',
        );
    }
}
