<?php

declare(strict_types=1);

namespace Tests\Unit\Metric\MetricTask\Application\UseCase\ChangeStatus;

use TaskFlow\Metric\MetricTask\Application\UseCase\ChangeStatus\ChangeMetricTaskStatus;
use TaskFlow\Metric\MetricTask\Application\UseCase\ChangeStatus\ChangeMetricTaskStatusHandler;
use Tests\Double\Core\Task\Domain\TaskStatusMother;
use Tests\Double\Metric\MetricTask\Domain\MetricTaskMother;
use Tests\Double\Metric\MetricTask\Domain\MetricTaskMotherRepository;
use Tests\Double\Shared\UuidMother;

final class ChangeMetricTaskStatusHandlerTest extends MetricTaskMotherRepository
{
    private ChangeMetricTaskStatusHandler | null $handler;

    protected function setUp(): void
    {
        parent::setUp();

        $this->handler = new ChangeMetricTaskStatusHandler($this->repository());
    }

    public function test_do_nothing_when_task_not_found(): void
    {
        $command = $this->randomCommand();

        $this->givenNotFoundById($command->id);

        $this->thenNotSave();

        $this->dispatch($command, $this->handler);
    }

    public function test_do_nothing_when_status_is_same(): void
    {
        $command = $this->randomCommand();

        $this->givenFoundById($command->id, MetricTaskMother::create(id: $command->id, status: $command->status));

        $this->thenNotSave();

        $this->dispatch($command, $this->handler);
    }

    public function test_change_status(): void
    {
        $command = $this->randomCommand();

        $newStatus = TaskStatusMother::different(TaskStatusMother::createFromString($command->status))->value();

        $metricTask = MetricTaskMother::create(id: $command->id, status: $newStatus);

        $this->givenFoundById($command->id, $metricTask);

        $this->thenSave($metricTask);

        $this->dispatch($command, $this->handler);
    }

    private function randomCommand(): ChangeMetricTaskStatus
    {
        $id = UuidMother::create();

        return new ChangeMetricTaskStatus(
            id: $id->value(),
            status: TaskStatusMother::random()->value,
        );
    }
}
