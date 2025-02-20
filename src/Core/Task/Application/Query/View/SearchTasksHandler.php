<?php

declare(strict_types=1);

namespace TaskFlow\Core\Task\Application\Query\View;

use TaskFlow\Core\Task\Domain\Task;
use TaskFlow\Core\Task\Domain\TaskRepository;
use TaskFlow\Shared\Domain\Bus\Query\QueryHandler;
use TaskFlow\Shared\Domain\Uuid;

final class SearchTasksHandler implements QueryHandler
{
    public function __construct(
        private readonly TaskRepository $repository,
        private readonly TaskViewAssembler $itemAssembler,
    ) {
    }

    /** @return list<TaskView> */
    public function __invoke(SearchTasks $query): array
    {
        return array_map(
            fn(Task $task): TaskView => $this->itemAssembler->invoke($task),
            $this->repository->searchAllByCreatorId(Uuid::create($query->userId)),
        );
    }
}
