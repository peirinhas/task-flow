<?php

declare(strict_types=1);

namespace TaskFlow\Core\Task\Application\Query\View;

use TaskFlow\Core\Task\Application\Query\View\Exception\TaskViewNotFound;
use TaskFlow\Shared\Infrastructure\Bus\Query\QueryBus;

final class SearchTaskViewByIdFinder
{
    public function __construct(private readonly QueryBus $queryBus)
    {
    }

    public function invoke(string $id, string $userId): TaskView
    {
        return $this->queryBus->ask(new SearchTaskById($id, $userId))
            ?? throw TaskViewNotFound::byId($id);
    }
}
