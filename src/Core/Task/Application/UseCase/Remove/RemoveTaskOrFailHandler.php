<?php

declare(strict_types=1);

namespace TaskFlow\Core\Task\Application\UseCase\Remove;

use TaskFlow\Core\Task\Domain\Service\EnsureTaskOwnership;
use TaskFlow\Core\Task\Domain\Service\TaskByIdFinder;
use TaskFlow\Core\Task\Domain\TaskRepository;
use TaskFlow\Shared\Domain\Bus\Command\CommandHandler;
use TaskFlow\Shared\Domain\Bus\Event\EventBus;

final class RemoveTaskOrFailHandler implements CommandHandler
{
    public function __construct(
        private readonly TaskRepository $repository,
        private readonly TaskByIdFinder $finder,
        private readonly EventBus $bus,
        private readonly EnsureTaskOwnership $ensureTaskOwnership,
    ) {
    }

    public function __invoke(RemoveTaskOrFail $command): void
    {
        $aggregateRoot = $this->finder->invoke($command->id);

        $this->ensureTaskOwnership->invoke($aggregateRoot, $command->userId);

        $this->repository->remove($aggregateRoot);

        $aggregateRoot->removed();

        $this->bus->publish(...$aggregateRoot->pullDomainEvents());
    }
}
