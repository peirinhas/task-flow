<?php

declare(strict_types=1);

namespace TaskFlow\Metric\MetricTask\Application\UseCase\ChangeStatus;

use TaskFlow\Shared\Domain\Bus\Command\Command;

final class ChangeMetricTaskStatus implements Command
{
    public function __construct(public string $id, public string $status)
    {
    }
}
