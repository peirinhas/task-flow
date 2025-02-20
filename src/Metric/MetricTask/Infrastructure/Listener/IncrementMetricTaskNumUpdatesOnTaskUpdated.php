<?php

declare(strict_types=1);

namespace TaskFlow\Metric\MetricTask\Infrastructure\Listener;

use Symfony\Component\Messenger\MessageBusInterface;
use TaskFlow\Core\Task\Domain\Event\TaskUpdated;
use TaskFlow\Metric\MetricTask\Application\UseCase\IncrementNumUpdates\IncrementMetricTaskNumUpdates;
use TaskFlow\Shared\Domain\Bus\Event\DomainEventSubscriber;

final class IncrementMetricTaskNumUpdatesOnTaskUpdated implements DomainEventSubscriber
{
    public function __construct(private readonly MessageBusInterface $commandBus)
    {
    }

    public static function subscribedTo(): array
    {
        return [TaskUpdated::class];
    }

    public function __invoke(TaskUpdated $event): void
    {
        $this->commandBus->dispatch(
            new IncrementMetricTaskNumUpdates(id: $event->aggregateId()),
        );
    }
}
