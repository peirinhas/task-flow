<?php

declare(strict_types=1);

namespace TaskFlow\Core\Task\Application\UseCase\Create;

use TaskFlow\Core\Task\Domain\TaskDescription;
use TaskFlow\Core\Task\Domain\TaskPriority;
use TaskFlow\Core\Task\Domain\TaskStatus;
use TaskFlow\Core\Task\Domain\TaskTitle;
use TaskFlow\Shared\Domain\Bus\Command\Command;
use TaskFlow\Shared\Domain\Uuid;

final class CreateTaskOrFail implements Command
{
    public function __construct(
        public UUid $id,
        public TaskTitle $title,
        public TaskDescription $description,
        public UUid $creatorId,
        public TaskPriority $priority,
        public TaskStatus $status,
    ) {
    }
}
