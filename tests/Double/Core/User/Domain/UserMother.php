<?php

declare(strict_types=1);

namespace Tests\Double\Core\User\Domain;

use TaskFlow\Core\User\Domain\User;
use TaskFlow\Core\User\Domain\UserCreatedAt;
use TaskFlow\Core\User\Domain\UserEmailAddress;
use TaskFlow\Core\User\Domain\UserName;
use TaskFlow\Core\User\Domain\UserPassword;
use TaskFlow\Shared\Domain\Uuid;
use Tests\Double\Shared\UuidMother;

final class UserMother
{
    public static function create(
        ?Uuid $id = null,
        ?UserName $name = null,
        ?UserEmailAddress $email = null,
        ?UserPassword $password = null,
        ?UserCreatedAt $createdAt = null,
    ): User {
        return new User(
            id: $id ?? UuidMother::create(),
            name: $name ?? UserNameMother::create(),
            email: $email ?? UserEmailAddressMother::create(),
            password: $password ?? UserPasswordMother::create(),
            createdAt: $createdAt ?? UserCreatedAtMother::create(),
        );
    }
}
