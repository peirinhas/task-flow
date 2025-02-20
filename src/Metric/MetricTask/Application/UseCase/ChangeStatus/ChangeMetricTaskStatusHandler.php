<?php

declare(strict_types=1);

namespace TaskFlow\Metric\MetricTask\Application\UseCase\ChangeStatus;

use TaskFlow\Metric\MetricTask\Domain\MetricTaskRepository;
use TaskFlow\Shared\Domain\Bus\Command\CommandHandler;

final class ChangeMetricTaskStatusHandler implements CommandHandler
{
    public function __construct(private readonly MetricTaskRepository $repository)
    {
    }

    public function __invoke(ChangeMetricTaskStatus $command): void
    {
        $aggregateRoot = $this->repository->searchById($command->id);

        if ($aggregateRoot === null) {
            return;
        }

        if ($this->checkSameStatus($aggregateRoot->status(), $command->status)) {
            return;
        }

        $aggregateRoot->changeStatus($command->status);

        $this->repository->save($aggregateRoot);
    }

    private function checkSameStatus(string $aggregateStatus, string $commandStatus): bool
    {
        return $aggregateStatus === $commandStatus;
    }
}
