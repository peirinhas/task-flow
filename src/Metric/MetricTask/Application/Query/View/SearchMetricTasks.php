<?php

declare(strict_types=1);

namespace TaskFlow\Metric\MetricTask\Application\Query\View;

use TaskFlow\Shared\Domain\Bus\Query\Query;

final class SearchMetricTasks implements Query
{
    public function __construct(public string $userId)
    {
    }
}
