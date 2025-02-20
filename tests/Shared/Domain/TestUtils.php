<?php

declare(strict_types=1);

namespace Tests\Shared\Domain;

use Tests\Shared\Infrastructure\Mockery\TaskFlowMatcherIsSimilar;
use Tests\Shared\Infrastructure\PhpUnit\Constraint\TaskFlowConstraintIsSimilar;

final class TestUtils
{
    public static function isSimilar(mixed $expected, mixed $actual): bool
    {
        $constraint = new TaskFlowConstraintIsSimilar($expected);

        return $constraint->evaluate($actual, '', true);
    }

    public static function assertSimilar(mixed $expected, mixed $actual): void
    {
        $constraint = new TaskFlowConstraintIsSimilar($expected);

        $constraint->evaluate($actual);
    }

    public static function similarTo(mixed $value, float $delta = 0.0): TaskFlowMatcherIsSimilar
    {
        return new TaskFlowMatcherIsSimilar($value, $delta);
    }
}
