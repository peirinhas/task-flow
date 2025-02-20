<?php

declare(strict_types=1);

namespace Tests\Double\Shared;

final class NumberMother
{
    public const DEFAULT_MAX = 10000;

    public static function create(): int
    {
        return self::between(0, 100);
    }

    public static function between(int $min, int $max = self::DEFAULT_MAX): int
    {
        return PrimitiveMother::between($min, $max);
    }
}
