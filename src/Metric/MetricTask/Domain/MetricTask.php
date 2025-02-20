<?php

declare(strict_types=1);

namespace TaskFlow\Metric\MetricTask\Domain;

use TaskFlow\Shared\Domain\Aggregate\AggregateRoot;

final class MetricTask extends AggregateRoot
{
    public function __construct(
        private readonly string $id,
        private readonly string $creatorId,
        private string $status,
        private int $numUpdates,
    ) {
    }

    public static function create(
        string $id,
        string $creatorId,
        string $status,
        int $numUpdates = 0,
    ): self {

        return new self(
            id: $id,
            creatorId: $creatorId,
            status: $status,
            numUpdates: $numUpdates,
        );
    }

    public function id(): string
    {
        return $this->id;
    }

    public function creatorId(): string
    {
        return $this->creatorId;
    }

    public function changeStatus(string $status): void
    {
        $this->status = $status;
    }

    public function status(): string
    {
        return $this->status;
    }

    public function changeNumUpdates(int $numUpdates): void
    {
        $this->numUpdates = $numUpdates;
    }

    public function numUpdates(): int
    {
        return $this->numUpdates;
    }
}
