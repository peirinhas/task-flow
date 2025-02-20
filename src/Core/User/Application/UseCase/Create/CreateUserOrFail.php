<?php

declare(strict_types=1);

namespace TaskFlow\Core\User\Application\UseCase\Create;

use TaskFlow\Core\User\Domain\UserEmailAddress;
use TaskFlow\Core\User\Domain\UserName;
use TaskFlow\Core\User\Domain\UserPassword;
use TaskFlow\Shared\Domain\Bus\Command\Command;
use TaskFlow\Shared\Domain\Uuid;

final class CreateUserOrFail implements Command
{
    public function __construct(
        public UUid $id,
        public UserName $name,
        public UserEmailAddress $email,
        public UserPassword $password,
    ) {
    }
}
