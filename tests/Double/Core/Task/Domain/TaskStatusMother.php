<?php

declare(strict_types=1);

namespace Tests\Double\Core\Task\Domain;

use TaskFlow\Core\Task\Domain\TaskStatus;
use Tests\Double\Shared\DifferentMother;

final class TaskStatusMother
{
    public static function createFromString(string $status = null): TaskStatus
    {
        return TaskStatus::from($status) ?? self::random();
    }

    public static function random(): TaskStatus
    {
        $status = TaskStatus::cases();
        return $status[array_rand($status)];
    }

    public static function different(TaskStatus $existing): TaskStatus
    {
        return DifferentMother::different(
            static fn(): TaskStatus => self::random(),
            $existing,
        );
    }
}
