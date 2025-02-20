<?php

declare(strict_types=1);

namespace TaskFlow\Metric\MetricTask\Application\Query\View;

use TaskFlow\Metric\MetricTask\Domain\MetricTask;
use TaskFlow\Shared\Application\Query\ViewAssembler;

final class MetricTaskViewAssembler implements ViewAssembler
{
    public function invoke(MetricTask $aggregateRoot): ?MetricTaskView
    {
        return new MetricTaskView(
            id: $aggregateRoot->id(),
            creatorId: $aggregateRoot->creatorId(),
            status: $aggregateRoot->status(),
            numUpdates: $aggregateRoot->numUpdates(),
        );
    }
}
