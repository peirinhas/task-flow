<?php

declare(strict_types=1);

namespace TaskFlow\Core\Task\Application\Query\View\Exception;

use TaskFlow\Core\Task\Application\Query\View\TaskView;
use TaskFlow\Shared\Domain\Exception\NotFoundException;

final class TaskViewNotFound extends NotFoundException
{
    public static function byId(string $id): self
    {
        return new self(
            parent::notFoundMessage(TaskView::class, "id <$id>"),
            'task.not_found',
        );
    }
}
