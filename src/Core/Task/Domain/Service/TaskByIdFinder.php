<?php

declare(strict_types=1);

namespace TaskFlow\Core\Task\Domain\Service;

use TaskFlow\Core\Task\Domain\Exception\TaskNotFound;
use TaskFlow\Core\Task\Domain\Task;
use TaskFlow\Core\Task\Domain\TaskRepository;
use TaskFlow\Shared\Domain\Uuid;

final class TaskByIdFinder
{
    public function __construct(private readonly TaskRepository $repository)
    {
    }

    public function invoke(Uuid $id): Task
    {
        return $this->repository->searchById($id) ?? throw TaskNotFound::byId($id);
    }
}
