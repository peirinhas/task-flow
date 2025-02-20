<?php

declare(strict_types=1);

namespace TaskFlow\Core\Task\Application\Query\View;

use TaskFlow\Shared\Application\Query\View;

final class TaskView implements View
{
    public function __construct(
        public string $id,
        public string $title,
        public string $description,
        public string $creatorId,
        public string $priority,
        public string $status,
        public string $createdAt,
        public string $updatedAt,
    ) {
    }
}
