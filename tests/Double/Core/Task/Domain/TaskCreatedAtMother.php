<?php

declare(strict_types=1);

namespace Tests\Double\Core\Task\Domain;

use TaskFlow\Core\Task\Domain\TaskCreatedAt;
use TaskFlow\Shared\Domain\Utils;
use Tests\Double\Shared\DateTimeImmutableMother;

final class TaskCreatedAtMother
{
    public static function create(?string $value = null): TaskCreatedAt
    {
        return TaskCreatedAt::createFromAtom(
            $value ?? Utils::dateToString(DateTimeImmutableMother::now())
        );
    }
}
