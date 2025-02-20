<?php

declare(strict_types=1);

namespace Tests\Unit\Metric\MetricTask\Application\UseCase\IncrementNumUpdates;

use PHPUnit\Framework\Assert;
use TaskFlow\Metric\MetricTask\Application\UseCase\IncrementNumUpdates\IncrementMetricTaskNumUpdates;
use TaskFlow\Metric\MetricTask\Application\UseCase\IncrementNumUpdates\IncrementMetricTaskNumUpdatesHandler;
use Tests\Double\Metric\MetricTask\Domain\MetricTaskMother;
use Tests\Double\Metric\MetricTask\Domain\MetricTaskMotherRepository;
use Tests\Double\Shared\NumberMother;
use Tests\Double\Shared\UuidMother;

final class IncrementMetricTaskNumUpdatesHandlerTest extends MetricTaskMotherRepository
{
    private IncrementMetricTaskNumUpdatesHandler | null $handler;

    protected function setUp(): void
    {
        parent::setUp();

        $this->handler = new IncrementMetricTaskNumUpdatesHandler($this->repository());
    }

    public function test_do_nothing_when_task_not_found(): void
    {
        $command = $this->randomCommand();

        $this->givenNotFoundById($command->id);

        $this->thenNotSave();

        $this->dispatch($command, $this->handler);
    }

    public function test_increment_num_updates(): void
    {
        $command = $this->randomCommand();

        $numUpdates = NumberMother::between(1, 20);
        $metricTask = MetricTaskMother::create(id: $command->id, numUpdates: $numUpdates);
        $metricTaskAfter = MetricTaskMother::create(
            id: $command->id,
            creatorId: $metricTask->creatorId(),
            status: $metricTask->status(),
            numUpdates: $numUpdates + 1,
        );

        $this->givenFoundById($command->id, $metricTask);

        $this->thenSave($metricTaskAfter);

        Assert::assertEquals($metricTaskAfter->numUpdates(), $metricTask->numUpdates() + 1);

        $this->dispatch($command, $this->handler);
    }

    private function randomCommand(): IncrementMetricTaskNumUpdates
    {
        return new IncrementMetricTaskNumUpdates(UuidMother::create()->value());
    }
}
