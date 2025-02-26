<?php

declare(strict_types=1);

namespace Tests\Double\Metric\MetricTask\Domain;

use Mockery\MockInterface;
use TaskFlow\Metric\MetricTask\Domain\MetricTask;
use TaskFlow\Metric\MetricTask\Domain\MetricTaskRepository;
use Tests\Shared\Infrastructure\PhpUnit\UnitTestCase;

abstract class MetricTaskMotherRepository extends UnitTestCase
{
    private MetricTaskRepository | MockInterface | null $repository = null;

    protected function thenAdd(MetricTask $metricTask): void
    {
        $this->repository()
            ->shouldReceive('add')
            ->with($this->similarTo($metricTask))
            ->once()
            ->andReturnNull();
    }

    public function thenNotAdd(): void
    {
        $this->repository()
            ->shouldNotReceive('add');
    }

    protected function thenRemove(MetricTask $metricTask): void
    {
        $this->repository()
            ->shouldReceive('remove')
            ->with($this->similarTo($metricTask))
            ->once()
            ->andReturnNull();
    }

    public function thenNotRemove(): void
    {
        $this->repository()
            ->shouldNotReceive('remove');
    }

    protected function thenSave(MetricTask $metricTask): void
    {
        $this->repository()
            ->shouldReceive('save')
            ->with($this->similarTo($metricTask))
            ->once()
            ->andReturnNull();
    }

    public function thenNotSave(): void
    {
        $this->repository()
            ->shouldNotReceive('save');
    }

    protected function givenFoundById(string $id, MetricTask $aggregateRoot): void
    {
        $this->repository()
            ->shouldReceive('searchById')
            ->with(
                self::similarTo($id),
            )
            ->andReturn($aggregateRoot);
    }

    protected function givenNotFoundById(string $id): void
    {
        $this->repository()
            ->shouldReceive('searchById')
            ->with(
                self::similarTo($id),
            )
            ->andReturnNull();
    }

    /** @param list<MetricTask> $aggregateRoot */
    protected function givenFoundByCreatorId(string $creatorId, array $aggregateRoot): void
    {
        $this->repository()
            ->shouldReceive('searchAllByCreatorId')
            ->with(
                self::similarTo($creatorId),
            )
            ->andReturn($aggregateRoot);
    }

    protected function givenNotFoundByCreatorId(string $creatorId): void
    {
        $this->repository()
            ->shouldReceive('searchAllByCreatorId')
            ->with(
                self::similarTo($creatorId),
            )
            ->andReturnNull();
    }

    protected function repository(): MetricTaskRepository | MockInterface
    {
        return $this->repository ??= $this->mock(MetricTaskRepository::class);
    }
}
