<?php

declare(strict_types=1);

namespace TaskFlow\Shared\Domain\Bus\Event;

use DateTimeImmutable;
use TaskFlow\Shared\Domain\Utils;
use TaskFlow\Shared\Domain\ValueObject\SimpleUuid;

abstract class DomainEvent
{
    private readonly string $eventId;
    private readonly string $occurredOn;

    public function __construct(private readonly string $aggregateId, string $eventId = null, string $occurredOn = null)
    {
        $this->eventId = $eventId ?: SimpleUuid::random()->value();
        $this->occurredOn = $occurredOn ?: Utils::dateToString(new DateTimeImmutable());
    }

    abstract public static function eventName(): string;

    abstract public function toPrimitives(): array;

    final public function aggregateId(): string
    {
        return $this->aggregateId;
    }

    final public function eventId(): string
    {
        return $this->eventId;
    }

    final public function occurredOn(): string
    {
        return $this->occurredOn;
    }
}
