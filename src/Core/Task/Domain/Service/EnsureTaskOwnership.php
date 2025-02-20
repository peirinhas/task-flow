<?php

declare(strict_types=1);

namespace TaskFlow\Core\Task\Domain\Service;

use TaskFlow\Core\Task\Domain\Exception\TaskOwnershipException;
use TaskFlow\Core\Task\Domain\Task;
use TaskFlow\Shared\Domain\Uuid;

final class EnsureTaskOwnership
{
    public function invoke(Task $task, Uuid $userId): void
    {
        if (!$task->creatorId()->equals($userId)) {
            throw TaskOwnershipException::create();
        }
    }
}
