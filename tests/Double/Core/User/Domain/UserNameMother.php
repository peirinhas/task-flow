<?php

declare(strict_types=1);

namespace Tests\Double\Core\User\Domain;

use TaskFlow\Core\User\Domain\UserName;
use Tests\Double\Shared\WordMother;

final class UserNameMother
{
    public static function create(?UserName $name = null): UserName
    {
        return new UserName(
            $name ?? WordMother::name(),
        );
    }
}
