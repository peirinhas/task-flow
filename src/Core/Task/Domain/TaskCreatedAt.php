<?php

declare(strict_types=1);

namespace TaskFlow\Core\Task\Domain;

use DateTimeZone;
use TaskFlow\Shared\Domain\ValueObject\DateTimeValueObject;

/** @psalm-immutable */
final class TaskCreatedAt extends DateTimeValueObject
{
    public static function createFromAtom(string $value, ?DateTimeZone $timezone = null): self
    {
        return new self($value, $timezone);
    }

    public static function createNow(?DateTimeZone $timezone = null): self
    {
        return new self('now', $timezone);
    }
}
