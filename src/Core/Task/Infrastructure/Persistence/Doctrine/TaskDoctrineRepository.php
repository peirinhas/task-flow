<?php

declare(strict_types=1);

namespace TaskFlow\Core\Task\Infrastructure\Persistence\Doctrine;

use TaskFlow\Core\Task\Domain\Task;
use TaskFlow\Core\Task\Domain\TaskRepository;
use TaskFlow\Shared\Domain\Uuid;
use TaskFlow\Shared\Infrastructure\Persistence\Doctrine\DoctrineRepository;

final class TaskDoctrineRepository extends DoctrineRepository implements TaskRepository
{
    public function add(Task $task): void
    {
        $this->persistAggregateRoot($task);
    }

    public function save(Task $task): void
    {
        $this->persistAggregateRoot($task);
    }

    public function searchById(Uuid $id): ?Task
    {
          return $this->repository(Task::class)->find($id);
    }

    public function searchAllByCreatorId(Uuid $creatorId): array
    {
        return $this->repository(Task::class)->findBy([ 'creatorId' => $creatorId]);
    }

    public function remove(Task $task): void
    {
        $this->removeAggregateRoot($task);
    }
}
