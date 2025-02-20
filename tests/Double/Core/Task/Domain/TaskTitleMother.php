<?php

declare(strict_types=1);

namespace Tests\Double\Core\Task\Domain;

use TaskFlow\Core\Task\Domain\TaskTitle;
use TaskFlow\Core\User\Domain\UserName;
use Tests\Double\Shared\DifferentMother;
use Tests\Double\Shared\WordMother;

final class TaskTitleMother
{
    public static function create(?UserName $name = null): TaskTitle
    {
        return new TaskTitle(
            $name ?? WordMother::create(),
        );
    }

    public static function different(TaskTitle $existing): TaskTitle
    {
        return DifferentMother::different(
            static fn(): TaskTitle => self::create(),
            $existing,
        );
    }
}
