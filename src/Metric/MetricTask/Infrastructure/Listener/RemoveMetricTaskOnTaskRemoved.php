<?php

declare(strict_types=1);

namespace TaskFlow\Metric\MetricTask\Infrastructure\Listener;

use Symfony\Component\Messenger\MessageBusInterface;
use TaskFlow\Core\Task\Domain\Event\TaskRemoved;
use TaskFlow\Metric\MetricTask\Application\UseCase\Remove\RemoveMetricTask;
use TaskFlow\Shared\Domain\Bus\Event\DomainEventSubscriber;

final class RemoveMetricTaskOnTaskRemoved implements DomainEventSubscriber
{
    public function __construct(private readonly MessageBusInterface $commandBus)
    {
    }

    public static function subscribedTo(): array
    {
        return [TaskRemoved::class];
    }

    public function __invoke(TaskRemoved $event): void
    {
        $this->commandBus->dispatch(
            new RemoveMetricTask(
                id: $event->aggregateId(),
            ),
        );
    }
}
