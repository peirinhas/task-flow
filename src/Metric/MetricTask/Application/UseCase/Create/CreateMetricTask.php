<?php

declare(strict_types=1);

namespace TaskFlow\Metric\MetricTask\Application\UseCase\Create;

use TaskFlow\Shared\Domain\Bus\Command\Command;

final class CreateMetricTask implements Command
{
    public function __construct(public string $id, public string $creatorId, public string $status)
    {
    }
}
