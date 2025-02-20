<?php

declare(strict_types=1);

namespace TaskFlow\Metric\MetricTask\Application\Query\View;

use TaskFlow\Metric\MetricTask\Domain\MetricTask;
use TaskFlow\Metric\MetricTask\Domain\MetricTaskRepository;
use TaskFlow\Shared\Domain\Bus\Query\QueryHandler;

final class SearchMetricTasksHandler implements QueryHandler
{
    public function __construct(
        private readonly MetricTaskRepository $repository,
        private readonly MetricTaskViewAssembler $itemAssembler,
    ) {
    }

    /** @return list<MetricTaskView> */
    public function __invoke(SearchMetricTasks $query): array
    {
        return array_map(
            fn(MetricTask $task): MetricTaskView => $this->itemAssembler->invoke($task),
            $this->repository->searchAllByCreatorId($query->userId)
        );
    }
}
