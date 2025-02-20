<?php

declare(strict_types=1);

namespace Tests\Double\Core\User\Domain;

use TaskFlow\Core\User\Domain\UserPassword;
use Tests\Double\Shared\PrimitiveMother;

final class UserPasswordMother
{
    public static function create(?string $value = null): UserPassword
    {
        return UserPassword::create(
            $value ?? PrimitiveMother::password(8, 20),
        );
    }

    public static function createFromHash(string $value): UserPassword
    {
        return UserPassword::createFromHash($value);
    }
}
