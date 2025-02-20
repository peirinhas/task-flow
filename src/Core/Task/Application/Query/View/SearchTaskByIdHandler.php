<?php

declare(strict_types=1);

namespace TaskFlow\Core\Task\Application\Query\View;

use TaskFlow\Core\Task\Domain\Service\EnsureTaskOwnership;
use TaskFlow\Core\Task\Domain\TaskRepository;
use TaskFlow\Shared\Domain\Bus\Query\QueryHandler;
use TaskFlow\Shared\Domain\Uuid;

final class SearchTaskByIdHandler implements QueryHandler
{
    public function __construct(
        private readonly TaskRepository $repository,
        private readonly TaskViewAssembler $assembler,
        private readonly EnsureTaskOwnership $ensureTaskOwnership,
    ) {
    }

    public function __invoke(SearchTaskById $query): ?TaskView
    {
        $aggregateRoot = $this->repository->searchById(Uuid::create($query->id));

        if ($aggregateRoot === null) {
            return null;
        }

        $this->ensureTaskOwnership->invoke($aggregateRoot, Uuid::create($query->userId));

        return $this->assembler->invoke($aggregateRoot);
    }
}
