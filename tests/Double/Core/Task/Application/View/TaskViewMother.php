<?php

declare(strict_types=1);

namespace Tests\Double\Core\Task\Application\View;

use TaskFlow\Core\Task\Application\Query\View\TaskView;
use Tests\Double\Core\Task\Domain\TaskCreatedAtMother;
use Tests\Double\Core\Task\Domain\TaskDescriptionMother;
use Tests\Double\Core\Task\Domain\TaskPriorityMother;
use Tests\Double\Core\Task\Domain\TaskStatusMother;
use Tests\Double\Core\Task\Domain\TaskTitleMother;
use Tests\Double\Core\Task\Domain\TaskUpdatedAtMother;
use Tests\Double\Shared\UuidMother;

final class TaskViewMother
{
    public static function create(
        ?string $id = null,
        ?string $title = null,
        ?string $description = null,
        ?string $creatorId = null,
        ?string $priority = null,
        ?string $status = null,
        ?string $createdAt = null,
        ?string $updatedAt = null,
    ): TaskView {
        return new TaskView(
            id: $id ?? UuidMother::create()->value(),
            title: $title ?? TaskTitleMother::create()->value(),
            description: $description ?? TaskDescriptionMother::create()->value(),
            creatorId: $creatorId ?? UuidMother::create()->value(),
            priority: $priority ?? TaskPriorityMother::random()->value(),
            status: $status ?? TaskStatusMother::random()->value(),
            createdAt: $createdAt ?? TaskCreatedAtMother::create()->atomFormatted(),
            updatedAt: $updatedAt ?? TaskUpdatedAtMother::create()->atomFormatted(),
        );
    }
}
