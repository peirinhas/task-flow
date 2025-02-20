<?php

declare(strict_types=1);

namespace Tests\Double\Core\Task\Domain;

use Mockery\MockInterface;
use TaskFlow\Core\Task\Domain\Task;
use TaskFlow\Core\Task\Domain\TaskRepository;
use TaskFlow\Shared\Domain\Uuid;
use Tests\Shared\Infrastructure\PhpUnit\UnitTestCase;

abstract class TaskMotherRepository extends UnitTestCase
{
    private TaskRepository | MockInterface | null $repository = null;

    protected function thenAdd(Task $task): void
    {
        $this->repository()
            ->shouldReceive('add')
            ->with($this->similarTo($task))
            ->once()
            ->andReturnNull();
    }

    public function thenNotAdd(): void
    {
        $this->repository()
            ->shouldNotReceive('add');
    }

    protected function thenSave(Task $task): void
    {
        $this->repository()
            ->shouldReceive('save')
            ->with($this->similarTo($task))
            ->once()
            ->andReturnNull();
    }

    public function thenNotSave(): void
    {
        $this->repository()
            ->shouldNotReceive('save');
    }

    protected function givenFoundById(Uuid $id, Task $aggregateRoot): void
    {
        $this->repository()
            ->shouldReceive('searchById')
            ->with(
                self::similarTo($id),
            )
            ->andReturn($aggregateRoot);
    }

    protected function givenNotFoundById(Uuid $id): void
    {
        $this->repository()
            ->shouldReceive('searchById')
            ->with(
                self::similarTo($id),
            )
            ->andReturnNull();
    }

    /** @param list<Task> $aggregateRoot */
    protected function givenFoundByCreatorId(Uuid $creatorId, array $aggregateRoot): void
    {
        $this->repository()
            ->shouldReceive('searchAllByCreatorId')
            ->with(
                self::similarTo($creatorId),
            )
            ->andReturn($aggregateRoot);
    }

    protected function givenNotFoundByCreatorId(Uuid $creatorId): void
    {
        $this->repository()
            ->shouldReceive('searchAllByCreatorId')
            ->with(
                self::similarTo($creatorId),
            )
            ->andReturnNull();
    }

    protected function thenRemove(Task $task): void
    {
        $this->repository()
            ->shouldReceive('remove')
            ->with($this->similarTo($task))
            ->once()
            ->andReturnNull();
    }

    public function thenNotRemove(): void
    {
        $this->repository()
            ->shouldNotReceive('remove');
    }

    protected function repository(): TaskRepository | MockInterface
    {
        return $this->repository ??= $this->mock(TaskRepository::class);
    }
}
