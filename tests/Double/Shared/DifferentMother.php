<?php

declare(strict_types=1);

namespace Tests\Double\Shared;

use OverflowException;

final class DifferentMother
{
    /**
     * @template R
     * @param callable():R $generator
     * @param R $valueNotAllowed
     * @return R
     */
    public static function different(callable $generator, mixed $valueNotAllowed, int $maxRetries = 10000): mixed
    {
        return self::notIn($generator, [$valueNotAllowed], $maxRetries);
    }

    /**
     * @template R
     * @param callable():R $generator
     * @param array<R> $valuesNotAllowed
     * @return R
     */
    public static function notIn(callable $generator, array $valuesNotAllowed, int $maxRetries = 10000): mixed
    {
        $i = 0;
        do {
            $value = $generator();
            ++$i;
        } while (in_array($value, $valuesNotAllowed, false) && $i < $maxRetries);

        if ($maxRetries <= $i) {
            throw new OverflowException("<$maxRetries> maximum retries reached without finding a unique value");
        }

        return $value;
    }
}
