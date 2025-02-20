<?php

declare(strict_types=1);

namespace Tests\Double\Metric\MetricTask\Application\View;

use TaskFlow\Metric\MetricTask\Application\Query\View\MetricTaskView;
use Tests\Double\Core\Task\Domain\TaskStatusMother;
use Tests\Double\Shared\NumberMother;
use Tests\Double\Shared\UuidMother;

final class MetricTaskViewMother
{
    public static function create(
        ?string $id = null,
        ?string $creatorId = null,
        ?string $status = null,
        ?int $numUpdates = null,
    ): MetricTaskView {
        return new MetricTaskView(
            id: $id ?? UuidMother::create()->value(),
            creatorId: $creatorId ?? UuidMother::create()->value(),
            status: $status ?? TaskStatusMother::random()->value(),
            numUpdates: $numUpdates ?? NumberMother::create(),
        );
    }
}
