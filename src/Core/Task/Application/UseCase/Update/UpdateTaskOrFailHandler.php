<?php

declare(strict_types=1);

namespace TaskFlow\Core\Task\Application\UseCase\Update;

use TaskFlow\Core\Task\Domain\Service\EnsureTaskOwnership;
use TaskFlow\Core\Task\Domain\Service\TaskByIdFinder;
use TaskFlow\Core\Task\Domain\Task;
use TaskFlow\Core\Task\Domain\TaskRepository;
use TaskFlow\Shared\Domain\Bus\Command\CommandHandler;
use TaskFlow\Shared\Domain\Bus\Event\EventBus;

final class UpdateTaskOrFailHandler implements CommandHandler
{
    public function __construct(
        private readonly TaskRepository $repository,
        private readonly TaskByIdFinder $finder,
        private readonly EventBus $bus,
        private readonly EnsureTaskOwnership $ensureTaskOwnership,
    ) {
    }

    public function __invoke(UpdateTaskOrFail $command): void
    {
        $aggregateRoot = $this->finder->invoke($command->id);

        $this->ensureTaskOwnership->invoke($aggregateRoot, $command->userId);

        if ($this->equals($aggregateRoot, $command)) {
            return;
        }

        $aggregateRoot->changeTitle($command->title);
        $aggregateRoot->changeDescription($command->description);
        $aggregateRoot->changePriority($command->priority);
        $aggregateRoot->changeStatus($command->status);

        $this->repository->save($aggregateRoot);

        $aggregateRoot->updated();

        $this->bus->publish(...$aggregateRoot->pullDomainEvents());
    }

    private function equals(Task $aggregateRoot, UpdateTaskOrFail $command): bool
    {
        return $aggregateRoot->equals(
            Task::create(
                id: $command->id,
                title: $command->title,
                description: $command->description,
                creatorId: $command->userId,
                priority: $command->priority,
                status: $command->status,
            ),
        );
    }
}
