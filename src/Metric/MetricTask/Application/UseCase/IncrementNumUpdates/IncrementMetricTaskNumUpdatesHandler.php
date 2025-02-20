<?php

declare(strict_types=1);

namespace TaskFlow\Metric\MetricTask\Application\UseCase\IncrementNumUpdates;

use TaskFlow\Metric\MetricTask\Domain\MetricTaskRepository;
use TaskFlow\Shared\Domain\Bus\Command\CommandHandler;

final class IncrementMetricTaskNumUpdatesHandler implements CommandHandler
{
    public function __construct(private readonly MetricTaskRepository $repository)
    {
    }

    public function __invoke(IncrementMetricTaskNumUpdates $command): void
    {
        $aggregateRoot = $this->repository->searchById($command->id);

        if ($aggregateRoot === null) {
            return;
        }

        $aggregateRoot->changeNumUpdates($aggregateRoot->numUpdates() + 1);

        $this->repository->save($aggregateRoot);
    }
}
