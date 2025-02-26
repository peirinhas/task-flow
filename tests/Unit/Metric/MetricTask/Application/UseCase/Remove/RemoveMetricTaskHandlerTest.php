<?php

declare(strict_types=1);

namespace Tests\Unit\Metric\MetricTask\Application\UseCase\Remove;

use TaskFlow\Metric\MetricTask\Application\UseCase\Remove\RemoveMetricTask;
use TaskFlow\Metric\MetricTask\Application\UseCase\Remove\RemoveMetricTaskHandler;
use Tests\Double\Core\Task\Domain\TaskStatusMother;
use Tests\Double\Metric\MetricTask\Domain\MetricTaskMother;
use Tests\Double\Metric\MetricTask\Domain\MetricTaskMotherRepository;
use Tests\Double\Shared\UuidMother;

final class RemoveMetricTaskHandlerTest extends MetricTaskMotherRepository
{
    private RemoveMetricTaskHandler | null $handler;

    protected function setUp(): void
    {
        parent::setUp();

        $this->handler = new RemoveMetricTaskHandler($this->repository());
    }

    public function test_do_nothing_when_task_not_exist(): void
    {
        $command = $this->randomCommand();

        $this->givenNotFoundById($command->id);

        $this->thenNotAdd();

        $this->dispatch($command, $this->handler);
    }

    public function test_remove_a_metric_task(): void
    {
        $command = $this->randomCommand();

        $metricTask = MetricTaskMother::create(
            id: $command->id,
        );

        $this->givenFoundById($command->id, $metricTask);

        $this->thenRemove($metricTask);

        $this->dispatch($command, $this->handler);
    }

    private function randomCommand(): RemoveMetricTask
    {
        $id = UuidMother::create();

        return new RemoveMetricTask(id: $id->value());
    }
}
