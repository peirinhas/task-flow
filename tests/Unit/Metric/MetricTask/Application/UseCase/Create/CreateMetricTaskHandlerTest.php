<?php

declare(strict_types=1);

namespace Tests\Unit\Metric\MetricTask\Application\UseCase\Create;

use PHPUnit\Framework\Assert;
use TaskFlow\Metric\MetricTask\Application\UseCase\Create\CreateMetricTask;
use TaskFlow\Metric\MetricTask\Application\UseCase\Create\CreateMetricTaskHandler;
use Tests\Double\Core\Task\Domain\TaskStatusMother;
use Tests\Double\Metric\MetricTask\Domain\MetricTaskMother;
use Tests\Double\Metric\MetricTask\Domain\MetricTaskMotherRepository;
use Tests\Double\Shared\UuidMother;

final class CreateMetricTaskHandlerTest extends MetricTaskMotherRepository
{
    private CreateMetricTaskHandler | null $handler;

    protected function setUp(): void
    {
        parent::setUp();

        $this->handler = new CreateMetricTaskHandler($this->repository());
    }

    public function test_do_nothing_when_task_exist(): void
    {
        $command = $this->randomCommand();

        $task = MetricTaskMother::create(id: $command->id);
        $this->givenFoundById($command->id, $task);

        $this->thenNotAdd();

        $this->dispatch($command, $this->handler);
    }

    public function test_create_a_metric_task(): void
    {
        $command = $this->randomCommand();

        $metricTask = MetricTaskMother::create(
            id: $command->id,
            creatorId: $command->creatorId,
            status: $command->status,
            numUpdates: 0,
        );

        $this->givenNotFoundById($command->id);

        $this->thenAdd($metricTask);

        Assert::assertEquals($metricTask->numUpdates(), 0);

        $this->dispatch($command, $this->handler);
    }

    private function randomCommand(): CreateMetricTask
    {
        $id = UuidMother::create();

        return new CreateMetricTask(
            id: $id->value(),
            creatorId: UuidMother::different($id)->value(),
            status: TaskStatusMother::random()->value,
        );
    }
}
