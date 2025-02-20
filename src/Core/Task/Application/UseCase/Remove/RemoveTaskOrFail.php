<?php

declare(strict_types=1);

namespace TaskFlow\Core\Task\Application\UseCase\Remove;

use TaskFlow\Shared\Domain\Bus\Command\Command;
use TaskFlow\Shared\Domain\Uuid;

final class RemoveTaskOrFail implements Command
{
    public function __construct(public UUid $id, public UUid $userId)
    {
    }
}
