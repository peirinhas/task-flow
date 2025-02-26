<?php

declare(strict_types=1);

namespace TaskFlow\Metric\MetricTask\Infrastructure\Persistence\Doctrine;

use TaskFlow\Metric\MetricTask\Domain\MetricTask;
use TaskFlow\Metric\MetricTask\Domain\MetricTaskRepository;
use TaskFlow\Shared\Infrastructure\Persistence\Doctrine\DoctrineRepository;

final class MetricTaskDoctrineRepository extends DoctrineRepository implements MetricTaskRepository
{
    public function add(MetricTask $metricTask): void
    {
        $this->persistAggregateRoot($metricTask);
    }

    public function remove(MetricTask $metricTask): void
    {
        $this->removeAggregateRoot($metricTask);
    }

    public function save(MetricTask $metricTask): void
    {
        $this->persistAggregateRoot($metricTask);
    }

    public function searchById(string $id): ?MetricTask
    {
        return $this->repository(MetricTask::class)->find($id);
    }

    public function searchAllByCreatorId(string $creatorId): array
    {
        return $this->repository(MetricTask::class)->findBy([ 'creatorId' => $creatorId]);
    }
}
