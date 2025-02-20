<?php

declare(strict_types=1);

namespace TaskFlow\Metric\MetricTask\Application\UseCase\Create;

use TaskFlow\Metric\MetricTask\Domain\MetricTask;
use TaskFlow\Metric\MetricTask\Domain\MetricTaskRepository;
use TaskFlow\Shared\Domain\Bus\Command\CommandHandler;

final class CreateMetricTaskHandler implements CommandHandler
{
    public function __construct(private readonly MetricTaskRepository $repository)
    {
    }

    public function __invoke(CreateMetricTask $command): void
    {
        if ($this->repository->searchById($command->id) !== null) {
            return;
        }

        $aggregate = MetricTask::create(id: $command->id, creatorId: $command->creatorId, status: $command->status);
        $this->repository->add($aggregate);
    }
}
