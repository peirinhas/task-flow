<?php

declare(strict_types=1);

namespace TaskFlow\Core\Task\Domain\Exception;

use TaskFlow\Shared\Domain\Exception\TaskFlowException;
use TaskFlow\Shared\Domain\Uuid;

class TaskOwnershipException extends TaskFlowException
{
    public static function create(): self
    {
        return new self(
            sprintf(
                'Task <%s> belongs to another owner',
                UUid::class,
            ),
            'task.ownership_exception',
        );
    }
}
