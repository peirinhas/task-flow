<?php

declare(strict_types=1);

namespace Tests\Double\Shared;

final class WordMother
{
    public static function create(): string
    {
        return PrimitiveMother::word();
    }

    public static function name(): string
    {
        return PrimitiveMother::name();
    }
}
