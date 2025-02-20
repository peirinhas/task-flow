<?php

declare(strict_types=1);

namespace TaskFlow\Metric\MetricTask\Application\UseCase\IncrementNumUpdates;

use TaskFlow\Shared\Domain\Bus\Command\Command;

final class IncrementMetricTaskNumUpdates implements Command
{
    public function __construct(public string $id)
    {
    }
}
