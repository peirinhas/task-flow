<?php

declare(strict_types=1);

namespace Tests\Unit\Core\Task\Application\UseCase\Update;

use TaskFlow\Core\Task\Application\UseCase\Update\UpdateTaskOrFail;
use TaskFlow\Core\Task\Application\UseCase\Update\UpdateTaskOrFailHandler;
use TaskFlow\Core\Task\Domain\Event\TaskUpdated;
use TaskFlow\Core\Task\Domain\Exception\TaskNotFound;
use TaskFlow\Core\Task\Domain\Exception\TaskOwnershipException;
use TaskFlow\Core\Task\Domain\Service\EnsureTaskOwnership;
use TaskFlow\Core\Task\Domain\Service\TaskByIdFinder;
use Tests\Double\Core\Task\Domain\TaskDescriptionMother;
use Tests\Double\Core\Task\Domain\TaskMother;
use Tests\Double\Core\Task\Domain\TaskMotherRepository;
use Tests\Double\Core\Task\Domain\TaskPriorityMother;
use Tests\Double\Core\Task\Domain\TaskStatusMother;
use Tests\Double\Core\Task\Domain\TaskTitleMother;
use Tests\Double\Shared\UuidMother;

final class UpdateTaskOrFailHandlerTest extends TaskMotherRepository
{
    private UpdateTaskOrFailHandler | null $handler;

    protected function setUp(): void
    {
        parent::setUp();

        $this->handler = new UpdateTaskOrFailHandler(
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

    public function test_task_do_nothing_same_values(): void
    {
        $command = $this->randomCommand();

        $task = TaskMother::create(
            id: $command->id,
            title: $command->title,
            description: $command->description,
            creatorId: $command->userId,
            priority: $command->priority,
            status: $command->status,
        );

        $this->givenFoundById($command->id, $task);

        $this->thenNotSave();

        $this->shouldNotPublishDomainEvent();

        $this->dispatch($command, $this->handler);
    }

    public function test_update_change_some__value_a_task(): void
    {
        $command = $this->randomCommand();

        $oldTask = TaskMother::create(
            id: $command->id,
            title: TaskTitleMother::different($command->title),
            description: $command->description,
            creatorId: $command->userId,
            priority: $command->priority,
            status: $command->status,
        );

        $this->givenFoundById($command->id, $oldTask);

        $taskUpdated = TaskMother::create(
            id: $command->id,
            title: $command->title,
            description: $command->description,
            creatorId: $command->userId,
            priority: $command->priority,
            status: $command->status,
        );

        $this->thenSave($taskUpdated);

        $this->shouldPublishDomainEvent(
            new TaskUpdated(
                id: $taskUpdated->id()->value(),
                title: $taskUpdated->title()->value(),
                description: $taskUpdated->description()->value(),
                creatorId: $taskUpdated->creatorId()->value(),
                priority: $taskUpdated->priority()->value(),
                status: $taskUpdated->status()->value(),
                createdAt: $taskUpdated->createdAt()->atomFormatted(),
                updatedAt: $taskUpdated->updatedAt()->atomFormatted(),
            ),
        );

        $this->dispatch($command, $this->handler);
    }

    private function randomCommand(): UpdateTaskOrFail
    {
        $id = UuidMother::create();

        return new UpdateTaskOrFail(
            id: $id,
            title: TaskTitleMother::create(),
            description: TaskDescriptionMother::create(),
            userId: UuidMother::different($id),
            priority: TaskPriorityMother::random(),
            status: TaskStatusMother::random(),
        );
    }
}
