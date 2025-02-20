<?php

declare(strict_types=1);

namespace TaskFlow\Metric\MetricTask\Application\Query\View;

use TaskFlow\Shared\Application\Query\View;

final class MetricTaskView implements View
{
    public function __construct(
        public string $id,
        public string $creatorId,
        public string $status,
        public int $numUpdates,
    ) {
    }
}
