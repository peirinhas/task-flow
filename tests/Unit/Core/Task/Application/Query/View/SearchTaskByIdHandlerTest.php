<?php

declare(strict_types=1);

namespace Tests\Unit\Core\Task\Application\Query\View;

use TaskFlow\Core\Task\Application\Query\View\SearchTaskById;
use TaskFlow\Core\Task\Application\Query\View\SearchTaskByIdHandler;
use TaskFlow\Core\Task\Application\Query\View\TaskViewAssembler;
use TaskFlow\Core\Task\Domain\Exception\TaskOwnershipException;
use TaskFlow\Core\Task\Domain\Service\EnsureTaskOwnership;
use Tests\Double\Core\Task\Application\View\TaskViewMother;
use Tests\Double\Core\Task\Domain\TaskMother;
use Tests\Double\Core\Task\Domain\TaskMotherRepository;
use Tests\Double\Shared\UuidMother;

final class SearchTaskByIdHandlerTest extends TaskMotherRepository
{
    private SearchTaskByIdHandler | null $queryHandler;

    protected function setUp(): void
    {
        parent::setUp();

        $this->queryHandler = new SearchTaskByIdHandler(
            repository: $this->repository(),
            assembler: new TaskViewAssembler(),
            ensureTaskOwnership: new EnsureTaskOwnership(),
        );
    }

    public function test_fails_not_found_a_task(): void
    {
        $query = $this->randomQuery();

        $this->givenNotFoundById(UuidMother::create($query->id));

        $this->assertAskResponse(null, $query, $this->queryHandler);
    }

    public function test_fails_task_not_ownership(): void
    {
        $query = $this->randomQuery();

        $id = UuidMother::create($query->id);
        $creatorId = UuidMother::different(UuidMother::create($query->userId));

        $aggregateRoot = TaskMother::create(id: $id, creatorId: $creatorId);
        $this->givenFoundById($id, $aggregateRoot);

        $this->assertAskThrowsException(TaskOwnershipException::class, $query, $this->queryHandler);
    }

    public function test_return_view(): void
    {
        $query = $this->randomQuery();

        $id = UuidMother::create($query->id);
        $userId = UuidMother::create($query->userId);

        $aggregateRoot = TaskMother::create(id: $id, creatorId: $userId);

        $this->givenFoundById($id, $aggregateRoot);
        $response = TaskViewMother::create(
            id: $aggregateRoot->id()->value(),
            title: $aggregateRoot->title()->value(),
            description: $aggregateRoot->description()->value(),
            creatorId: $aggregateRoot->creatorId()->value(),
            priority: $aggregateRoot->priority()->value(),
            status: $aggregateRoot->status()->value(),
            createdAt: $aggregateRoot->createdAt()->atomFormatted(),
            updatedAt: $aggregateRoot->updatedAt()->atomFormatted(),
        );

        $this->assertAskResponse($response, $query, $this->queryHandler);
    }

    private function randomQuery(): SearchTaskById
    {
        $id = UuidMother::create();
        return new SearchTaskById(
            id: $id->value(),
            userId: UuidMother::different($id)->value(),
        );
    }
}
