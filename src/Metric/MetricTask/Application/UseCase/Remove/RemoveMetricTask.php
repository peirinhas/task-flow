<?php

declare(strict_types=1);

namespace TaskFlow\Metric\MetricTask\Application\UseCase\Remove;

use TaskFlow\Shared\Domain\Bus\Command\Command;

final class RemoveMetricTask implements Command
{
    public function __construct(public string $id)
    {
    }
}
