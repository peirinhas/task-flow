<?php

declare(strict_types=1);

namespace TaskFlow\Metric\MetricTask\Application\UseCase\Remove;

use TaskFlow\Metric\MetricTask\Domain\MetricTaskRepository;
use TaskFlow\Shared\Domain\Bus\Command\CommandHandler;

final class RemoveMetricTaskHandler implements CommandHandler
{
    public function __construct(private readonly MetricTaskRepository $repository)
    {
    }

    public function __invoke(RemoveMetricTask $command): void
    {
        $aggregate = $this->repository->searchById($command->id);

        if ($aggregate === null) {
            return;
        }

        $this->repository->remove($aggregate);
    }
}
