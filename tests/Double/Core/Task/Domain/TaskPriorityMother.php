<?php

declare(strict_types=1);

namespace Tests\Double\Core\Task\Domain;

use TaskFlow\Core\Task\Domain\TaskPriority;

final class TaskPriorityMother
{
    public static function random(): TaskPriority
    {
        $priorities = TaskPriority::cases();
        return $priorities[array_rand($priorities)];
    }
}
