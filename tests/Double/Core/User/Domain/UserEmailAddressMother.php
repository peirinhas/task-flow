<?php

declare(strict_types=1);

namespace Tests\Double\Core\User\Domain;

use TaskFlow\Core\User\Domain\UserEmailAddress;
use Tests\Double\Shared\PrimitiveMother;
use Tests\Double\Shared\WordMother;

final class UserEmailAddressMother
{
    public static function create(?string $value = null): UserEmailAddress
    {
        return UserEmailAddress::create(
            $value ?? PrimitiveMother::email()
        );
    }
    public static function createBadFormat(?string $value = null): UserEmailAddress
    {
        return UserEmailAddress::create(
            $value ?? WordMother::create()
        );
    }
}
