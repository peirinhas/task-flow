<?php

declare(strict_types=1);

namespace TaskFlow\Metric\MetricTask\Domain;

interface MetricTaskRepository
{
    public function add(MetricTask $metricTask): void;

    public function remove(MetricTask $metricTask): void;

    public function save(MetricTask $metricTask): void;

    public function searchById(string $id): ?MetricTask;

    /**
     * @return list<MetricTask>
     */
    public function searchAllByCreatorId(string $creatorId): array;
}
