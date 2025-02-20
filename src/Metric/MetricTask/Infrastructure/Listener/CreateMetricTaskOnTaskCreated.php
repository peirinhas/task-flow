<?php

declare(strict_types=1);

namespace TaskFlow\Metric\MetricTask\Infrastructure\Listener;

use Symfony\Component\Messenger\MessageBusInterface;
use TaskFlow\Core\Task\Domain\Event\TaskCreated;
use TaskFlow\Metric\MetricTask\Application\UseCase\Create\CreateMetricTask;
use TaskFlow\Shared\Domain\Bus\Event\DomainEventSubscriber;

final class CreateMetricTaskOnTaskCreated implements DomainEventSubscriber
{
    public function __construct(private readonly MessageBusInterface $commandBus)
    {
    }

    public static function subscribedTo(): array
    {
        return [TaskCreated::class];
    }

    public function __invoke(TaskCreated $event): void
    {
        $this->commandBus->dispatch(
            new CreateMetricTask(
                id: $event->aggregateId(),
                creatorId: $event->creatorId(),
                status: $event->status(),
            ),
        );
    }
}
