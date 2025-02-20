<?php

declare(strict_types=1);

namespace TaskFlow\Core\Task\Domain\Event;

use TaskFlow\Shared\Domain\Bus\Event\DomainEvent;

final class TaskUpdated extends DomainEvent
{
    public function __construct(
        string $id,
        private readonly string $title,
        private readonly string $description,
        private readonly string $creatorId,
        private readonly string $priority,
        private readonly string $status,
        private readonly string $createdAt,
        private readonly string $updatedAt,
        string $eventId = null,
        string $occurredOn = null,
    ) {
        parent::__construct($id, $eventId, $occurredOn);
    }

    public static function eventName(): string
    {
        return 'task.updated';
    }

    /**
     * @return array<string,string>
     */
    public function toPrimitives(): array
    {
        return [
            'title' => $this->title,
            'description' => $this->description,
            'creatorId' => $this->creatorId,
            'priority' => $this->priority,
            'status' => $this->status,
            'createdAt' => $this->createdAt,
            'updatedAt' => $this->updatedAt,
        ];
    }


    public function title(): string
    {
        return $this->title;
    }

    public function description(): string
    {
        return $this->description;
    }

    public function creatorId(): string
    {
        return $this->creatorId;
    }

    public function priority(): string
    {
        return $this->priority;
    }

    public function status(): string
    {
        return $this->status;
    }

    public function createdAt(): string
    {
        return $this->createdAt;
    }

    public function updatedAt(): string
    {
        return $this->updatedAt;
    }
}
