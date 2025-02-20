<?php

declare(strict_types=1);

namespace Tests\Double\Metric\MetricTask\Domain;

use TaskFlow\Metric\MetricTask\Domain\MetricTask;
use Tests\Double\Core\Task\Domain\TaskStatusMother;
use Tests\Double\Shared\NumberMother;
use Tests\Double\Shared\UuidMother;

final class MetricTaskMother
{
    public static function create(
        ?string $id = null,
        ?string $creatorId = null,
        ?string $status = null,
        ?int $numUpdates = null,
    ): MetricTask {
        return new MetricTask(
            id: $id ?? UuidMother::create()->value(),
            creatorId: $creatorId ?? UuidMother::create()->value(),
            status: $status ?? TaskStatusMother::random()->value(),
            numUpdates: $numUpdates ?? NumberMother::create(),
        );
    }
}
