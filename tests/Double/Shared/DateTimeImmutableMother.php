<?php

declare(strict_types=1);

namespace Tests\Double\Shared;

use DateTimeImmutable;

final class DateTimeImmutableMother
{
    public static function now(): DateTimeImmutable
    {
        return new DateTimeImmutable('now');
    }
}
