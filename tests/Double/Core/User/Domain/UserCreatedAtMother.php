<?php

declare(strict_types=1);

namespace Tests\Double\Core\User\Domain;

use TaskFlow\Core\User\Domain\UserCreatedAt;
use TaskFlow\Shared\Domain\Utils;
use Tests\Double\Shared\DateTimeImmutableMother;

final class UserCreatedAtMother
{
    public static function create(?string $value = null): UserCreatedAt
    {
        return UserCreatedAt::createFromAtom(
            $value ?? Utils::dateToString(DateTimeImmutableMother::now())
        );
    }
}
