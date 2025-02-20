<?php

declare(strict_types=1);

namespace Tests\Unit\Core\Task\Application\UseCase\Create;

use TaskFlow\Core\Task\Application\UseCase\Create\CreateTaskOrFail;
use TaskFlow\Core\Task\Application\UseCase\Create\CreateTaskOrFailHandler;
use TaskFlow\Core\Task\Domain\Event\TaskCreated;
use TaskFlow\Core\Task\Domain\Exception\TaskAlreadyExists;
use Tests\Double\Core\Task\Domain\TaskDescriptionMother;
use Tests\Double\Core\Task\Domain\TaskMother;
use Tests\Double\Core\Task\Domain\TaskMotherRepository;
use Tests\Double\Core\Task\Domain\TaskPriorityMother;
use Tests\Double\Core\Task\Domain\TaskStatusMother;
use Tests\Double\Core\Task\Domain\TaskTitleMother;
use Tests\Double\Shared\UuidMother;

final class CreateTaskOrFailHandlerTest extends TaskMotherRepository
{
    private CreateTaskOrFailHandler | null $handler;

    protected function setUp(): void
    {
        parent::setUp();

        $this->handler = new CreateTaskOrFailHandler($this->repository(), $this->eventBus());
    }

    public function test_fails_when_uuid_exist(): void
    {
        $this->expectException(TaskAlreadyExists::class);

        $command = $this->randomCommand();

        $task = TaskMother::create(id: $command->id);
        $this->givenFoundById($command->id, $task);

        $this->thenNotAdd();

        $this->shouldNotPublishDomainEvent();

        $this->dispatch($command, $this->handler);
    }

    public function test_create_a_valid_task(): void
    {
        $command = $this->randomCommand();

        $task = TaskMother::create(
            id: $command->id,
            title: $command->title,
            description: $command->description,
            creatorId: $command->creatorId,
            priority: $command->priority,
            status: $command->status,
        );

        $this->givenNotFoundById($command->id);

        $this->thenAdd($task);

        $this->shouldPublishDomainEvent(
            new TaskCreated(
                id: $task->id()->value(),
                title: $task->title()->value(),
                description: $task->description()->value(),
                creatorId: $task->creatorId()->value(),
                priority: $task->priority()->value(),
                status: $task->status()->value(),
                createdAt: $task->createdAt()->atomFormatted(),
                updatedAt: $task->updatedAt()->atomFormatted(),
            ),
        );

        $this->dispatch($command, $this->handler);
    }

    private function randomCommand(): CreateTaskOrFail
    {
        $id = UuidMother::create();

        return new CreateTaskOrFail(
            id: $id,
            title: TaskTitleMother::create(),
            description: TaskDescriptionMother::create(),
            creatorId: UuidMother::different($id),
            priority: TaskPriorityMother::random(),
            status: TaskStatusMother::random(),
        );
    }
}
