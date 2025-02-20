<?php

declare(strict_types=1);

namespace Tests\Double\Core\Task\Domain;

use TaskFlow\Core\Task\Domain\TaskUpdatedAt;
use TaskFlow\Shared\Domain\Utils;
use Tests\Double\Shared\DateTimeImmutableMother;

final class TaskUpdatedAtMother
{
    public static function create(?string $value = null): TaskUpdatedAt
    {
        return TaskUpdatedAt::createFromAtom(
            $value ?? Utils::dateToString(DateTimeImmutableMother::now()),
        );
    }
}
