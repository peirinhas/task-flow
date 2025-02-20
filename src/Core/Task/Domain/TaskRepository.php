<?php

declare(strict_types=1);

namespace TaskFlow\Core\Task\Domain;

use TaskFlow\Shared\Domain\Uuid;

interface TaskRepository
{
    public function add(Task $task): void;

    public function save(Task $task): void;

    public function searchById(Uuid $id): ?Task;

    /**
     * @return list<Task>
     */
    public function searchAllByCreatorId(Uuid $creatorId): array;

    public function remove(Task $task): void;
}
