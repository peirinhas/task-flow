<?php

declare(strict_types=1);

namespace TaskFlow\Core\Task\Domain;

use TaskFlow\Core\Task\Domain\Event\TaskCreated;
use TaskFlow\Core\Task\Domain\Event\TaskRemoved;
use TaskFlow\Core\Task\Domain\Event\TaskUpdated;
use TaskFlow\Shared\Domain\Aggregate\AggregateRoot;
use TaskFlow\Shared\Domain\Uuid;

final class Task extends AggregateRoot
{
    public function __construct(
        private readonly UUid $id,
        private TaskTitle $title,
        private TaskDescription $description,
        private readonly UUid $creatorId,
        private TaskPriority $priority,
        private TaskStatus $status,
        private TaskCreatedAt $createdAt,
        private TaskUpdatedAt $updatedAt,
    ) {
    }

    public static function create(
        UUid $id,
        TaskTitle $title,
        TaskDescription $description,
        UUid $creatorId,
        TaskPriority $priority,
        TaskStatus $status,
    ): self {
        $createdAt = TaskCreatedAt::createNow();
        $updatedAt = TaskUpdatedAt::createNow();

        $aggregate = new self(
            id: $id,
            title: $title,
            description: $description,
            creatorId: $creatorId,
            priority: $priority,
            status: $status,
            createdAt: $createdAt,
            updatedAt: $updatedAt,
        );

        $aggregate->record(
            new TaskCreated(
                id: $id->value(),
                title: $title->value(),
                description: $description->value(),
                creatorId: $creatorId->value(),
                priority: $priority->value(),
                status: $status->value(),
                createdAt: $createdAt->atomFormatted(),
                updatedAt: $updatedAt->atomFormatted(),
            ),
        );

        return $aggregate;
    }

    public function id(): Uuid
    {
        return $this->id;
    }

    public function changeTitle(TaskTitle $title): void
    {
        if ($title->value() === $this->title()->value()) {
            return;
        }

        $this->title = $title;
    }

    public function title(): TaskTitle
    {
        return $this->title;
    }

    public function changeDescription(TaskDescription $description): void
    {
        if ($description->value() === $this->description()->value()) {
            return;
        }

        $this->description = $description;
    }

    public function description(): TaskDescription
    {
        return $this->description;
    }

    public function creatorId(): Uuid
    {
        return $this->creatorId;
    }

    public function changePriority(TaskPriority $priority): void
    {
        if ($priority->value() === $this->priority()->value()) {
            return;
        }

        $this->priority = $priority;
    }

    public function priority(): TaskPriority
    {
        return $this->priority;
    }

    public function changeStatus(TaskStatus $status): void
    {
        if ($status->value() === $this->status()->value()) {
            return;
        }

        $this->status = $status;
    }

    public function status(): TaskStatus
    {
        return $this->status;
    }

    public function createdAt(): TaskCreatedAt
    {
        return $this->createdAt;
    }

    public function changeUpdatedAt(): void
    {
        $this->updatedAt = TaskUpdatedAt::createNow();
    }

    public function updatedAt(): TaskUpdatedAt
    {
        return $this->updatedAt;
    }

    public function removed(): void
    {
        $this->record(
            new TaskRemoved(
                $this->id->value(),
                $this->creatorId->value(),
            ),
        );
    }

    public function updated(): void
    {
        $this->changeUpdatedAt();

        $this->record(
            new TaskUpdated(
                id: $this->id()->value(),
                title: $this->title()->value(),
                description: $this->description()->value(),
                creatorId: $this->creatorId()->value(),
                priority: $this->priority()->value(),
                status: $this->status()->value(),
                createdAt: $this->createdAt()->atomFormatted(),
                updatedAt: $this->updatedAt()->atomFormatted(),
            ),
        );
    }

    public function equals(self $other): bool
    {
        return $this->id()->value() === $other->id->value()
            && $this->title()->value() === $other->title()->value()
            && $this->description()->value() === $other->description()->value()
            && $this->creatorId()->value() === $other->creatorId()->value()
            && $this->priority()->value() === $other->priority()->value()
            && $this->status()->value() === $other->status()->value();
    }
}
