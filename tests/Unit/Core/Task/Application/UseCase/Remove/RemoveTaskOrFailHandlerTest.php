<?php

declare(strict_types=1);

namespace Tests\Unit\Core\Task\Application\UseCase\Remove;

use TaskFlow\Core\Task\Application\UseCase\Remove\RemoveTaskOrFail;
use TaskFlow\Core\Task\Application\UseCase\Remove\RemoveTaskOrFailHandler;
use TaskFlow\Core\Task\Domain\Event\TaskRemoved;
use TaskFlow\Core\Task\Domain\Exception\TaskNotFound;
use TaskFlow\Core\Task\Domain\Exception\TaskOwnershipException;
use TaskFlow\Core\Task\Domain\Service\EnsureTaskOwnership;
use TaskFlow\Core\Task\Domain\Service\TaskByIdFinder;
use Tests\Double\Core\Task\Domain\TaskMother;
use Tests\Double\Core\Task\Domain\TaskMotherRepository;
use Tests\Double\Shared\UuidMother;

final class RemoveTaskOrFailHandlerTest extends TaskMotherRepository
{
    private RemoveTaskOrFailHandler | null $handler;

    protected function setUp(): void
    {
        parent::setUp();

        $this->handler = new RemoveTaskOrFailHandler(
            repository: $this->repository(),
            finder: new TaskByIdFinder($this->repository()),
            bus: $this->eventBus(),
            ensureTaskOwnership: new EnsureTaskOwnership(),
        );
    }

    public function test_fails_not_found_a_task(): void
    {
        $this->expectException(TaskNotFound::class);

        $command = $this->randomCommand();

        $this->givenNotFoundById($command->id);

        $this->thenNotRemove();

        $this->shouldNotPublishDomainEvent();

        $this->dispatch($command, $this->handler);
    }

    public function test_fails_task_not_ownership(): void
    {
        $this->expectException(TaskOwnershipException::class);

        $command = $this->randomCommand();

        $task = TaskMother::create(
            id: $command->id,
            creatorId: UuidMother::different($command->userId),
        );

        $this->givenFoundById($command->id, $task);

        $this->thenNotRemove();

        $this->shouldNotPublishDomainEvent();

        $this->dispatch($command, $this->handler);
    }

    public function test_remove_a_task(): void
    {
        $command = $this->randomCommand();

        $task = TaskMother::create(
            id: $command->id,
            creatorId: $command->userId,
        );

        $this->givenFoundById($command->id, $task);

        $this->thenRemove($task);

        $this->shouldPublishDomainEvent(
            new TaskRemoved(
                id: $task->id()->value(),
                creatorId: $task->creatorId()->value(),
            ),
        );

        $this->dispatch($command, $this->handler);
    }

    private function randomCommand(): RemoveTaskOrFail
    {
        $id = UuidMother::create();
        return new RemoveTaskOrFail(
            id: $id,
            userId: UuidMother::different($id),
        );
    }
}
