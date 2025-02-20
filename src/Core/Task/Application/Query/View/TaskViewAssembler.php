<?php

declare(strict_types=1);

namespace TaskFlow\Core\Task\Application\Query\View;

use TaskFlow\Core\Task\Domain\Task;
use TaskFlow\Shared\Application\Query\ViewAssembler;

final class TaskViewAssembler implements ViewAssembler
{
    public function invoke(Task $aggregateRoot): ?TaskView
    {
        return new TaskView(
            id: $aggregateRoot->id()->value(),
            title: $aggregateRoot->title()->value(),
            description: $aggregateRoot->description()->value(),
            creatorId: $aggregateRoot->creatorId()->value(),
            priority: $aggregateRoot->priority()->value(),
            status: $aggregateRoot->status()->value(),
            createdAt: $aggregateRoot->createdAt()->atomFormatted(),
            updatedAt: $aggregateRoot->updatedAt()->atomFormatted(),
        );
    }
}
