<?php

declare(strict_types=1);

namespace TaskFlow\Core\Task\Application\UseCase\Create;

use TaskFlow\Core\Task\Domain\Exception\TaskAlreadyExists;
use TaskFlow\Core\Task\Domain\Task;
use TaskFlow\Core\Task\Domain\TaskRepository;
use TaskFlow\Shared\Domain\Bus\Command\CommandHandler;
use TaskFlow\Shared\Domain\Bus\Event\EventBus;
use TaskFlow\Shared\Domain\Uuid;

final class CreateTaskOrFailHandler implements CommandHandler
{
    public function __construct(private readonly TaskRepository $repository, private readonly EventBus $bus)
    {
    }

    public function __invoke(CreateTaskOrFail $command): void
    {
        $this->guardTaskIdExist($command->id);

        $aggregateRoot = Task::create(
            id: $command->id,
            title: $command->title,
            description: $command->description,
            creatorId: $command->creatorId,
            priority: $command->priority,
            status: $command->status,
        );

        $this->repository->add($aggregateRoot);
        $this->bus->publish(...$aggregateRoot->pullDomainEvents());
    }

    private function guardTaskIdExist(Uuid $id): void
    {
        if ($this->repository->searchById($id) !== null) {
            throw TaskAlreadyExists::create($id);
        }
    }
}
