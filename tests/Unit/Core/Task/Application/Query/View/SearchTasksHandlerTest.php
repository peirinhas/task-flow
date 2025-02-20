<?php

declare(strict_types=1);

namespace Tests\Unit\Core\Task\Application\Query\View;

use TaskFlow\Core\Task\Application\Query\View\SearchTasks;
use TaskFlow\Core\Task\Application\Query\View\SearchTasksHandler;
use TaskFlow\Core\Task\Application\Query\View\TaskViewAssembler;
use Tests\Double\Core\Task\Application\View\TaskViewMother;
use Tests\Double\Core\Task\Domain\TaskMother;
use Tests\Double\Core\Task\Domain\TaskMotherRepository;
use Tests\Double\Shared\UuidMother;

final class SearchTasksHandlerTest extends TaskMotherRepository
{
    private SearchTasksHandler | null $queryHandler;

    protected function setUp(): void
    {
        parent::setUp();

        $this->queryHandler = new SearchTasksHandler(
            repository: $this->repository(),
            itemAssembler: new TaskViewAssembler(),
        );
    }

    public function test_return_view(): void
    {
        $query = $this->randomQuery();

        $creatorId = UuidMother::create($query->userId);

        $firstTaskId = UuidMother::create();
        $firstTask = TaskMother::create(id: $firstTaskId, creatorId: $creatorId);
        $secondTask = TaskMother::create(
            id: UuidMother::different($firstTaskId),
            creatorId: $creatorId,
        );


        $list = [$firstTask, $secondTask];

        $this->givenFoundByCreatorId($creatorId, $list);

        $response =
            [
                TaskViewMother::create(
                    id: $firstTask->id()->value(),
                    title: $firstTask->title()->value(),
                    description: $firstTask->description()->value(),
                    creatorId: $firstTask->creatorId()->value(),
                    priority: $firstTask->priority()->value(),
                    status: $firstTask->status()->value(),
                    createdAt: $firstTask->createdAt()->atomFormatted(),
                    updatedAt: $firstTask->updatedAt()->atomFormatted(),
                ),
                TaskViewMother::create(
                    id: $secondTask->id()->value(),
                    title: $secondTask->title()->value(),
                    description: $secondTask->description()->value(),
                    creatorId: $secondTask->creatorId()->value(),
                    priority: $secondTask->priority()->value(),
                    status: $secondTask->status()->value(),
                    createdAt: $secondTask->createdAt()->atomFormatted(),
                    updatedAt: $secondTask->updatedAt()->atomFormatted(),
                ),
            ];

        $this->assertAskListResponse($response, $query, $this->queryHandler);
    }

    private function randomQuery(): SearchTasks
    {
        return new SearchTasks(
            userId: UuidMother::create()->value(),
        );
    }
}
