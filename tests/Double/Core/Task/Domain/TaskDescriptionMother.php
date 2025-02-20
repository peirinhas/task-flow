<?php

declare(strict_types=1);

namespace Tests\Double\Core\Task\Domain;

use TaskFlow\Core\Task\Domain\TaskDescription;
use TaskFlow\Core\User\Domain\UserName;
use Tests\Double\Shared\WordMother;

final class TaskDescriptionMother
{
    public static function create(?UserName $name = null): TaskDescription
    {
        return new TaskDescription(
            $name ?? WordMother::create(),
        );
    }
}
