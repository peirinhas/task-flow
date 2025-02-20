<?php

declare(strict_types=1);

namespace TaskFlow\Core\Task\Domain\Event;

use TaskFlow\Shared\Domain\Bus\Event\DomainEvent;

final class TaskRemoved extends DomainEvent
{
    public function __construct(
        string $id,
        private readonly string $creatorId,
        string $eventId = null,
        string $occurredOn = null,
    ) {
        parent::__construct($id, $eventId, $occurredOn);
    }

    public static function eventName(): string
    {
        return 'task.removed';
    }

    /**
     * @return array<string,string>
     */
    public function toPrimitives(): array
    {
        return [
            'creatorId' => $this->creatorId,
        ];
    }

    public function creatorId(): string
    {
        return $this->creatorId;
    }
}
