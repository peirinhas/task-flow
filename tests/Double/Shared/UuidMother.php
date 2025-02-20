<?php

declare(strict_types=1);

namespace Tests\Double\Shared;

use TaskFlow\Shared\Domain\Uuid;

final class UuidMother
{
    public static function create(string $uuid = null): Uuid
    {
        return  $uuid !== null ? Uuid::create($uuid) : PrimitiveMother::uuid();
    }

    public static function different(Uuid $existing): Uuid
    {
        return DifferentMother::different(
            static fn(): Uuid => self::create(),
            $existing,
        );
    }
}
