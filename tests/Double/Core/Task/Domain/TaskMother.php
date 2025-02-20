<?php

declare(strict_types=1);

namespace Tests\Double\Core\Task\Domain;

use TaskFlow\Core\Task\Domain\Task;
use TaskFlow\Core\Task\Domain\TaskCreatedAt;
use TaskFlow\Core\Task\Domain\TaskDescription;
use TaskFlow\Core\Task\Domain\TaskPriority;
use TaskFlow\Core\Task\Domain\TaskStatus;
use TaskFlow\Core\Task\Domain\TaskTitle;
use TaskFlow\Core\Task\Domain\TaskUpdatedAt;
use TaskFlow\Shared\Domain\Uuid;
use Tests\Double\Shared\UuidMother;

final class TaskMother
{
    public static function create(
        ?UUid $id = null,
        ?TaskTitle $title = null,
        ?TaskDescription $description = null,
        ?UUid $creatorId = null,
        ?TaskPriority $priority = null,
        ?TaskStatus $status = null,
        ?TaskCreatedAt $createdAt = null,
        ?TaskUpdatedAt $updatedAt = null,
    ): Task {
        return new Task(
            id: $id ?? UuidMother::create(),
            title: $title ?? TaskTitleMother::create(),
            description: $description ?? TaskDescriptionMother::create(),
            creatorId: $creatorId ?? UuidMother::create(),
            priority: $priority ?? TaskPriorityMother::random(),
            status: $status ?? TaskStatusMother::random(),
            createdAt: $createdAt ?? TaskCreatedAtMother::create(),
            updatedAt: $updatedAt ?? TaskUpdatedAtMother::create(),
        );
    }
}
