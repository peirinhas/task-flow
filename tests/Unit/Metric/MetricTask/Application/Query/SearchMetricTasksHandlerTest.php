<?php

declare(strict_types=1);

namespace Tests\Unit\Metric\MetricTask\Application\Query;

use TaskFlow\Metric\MetricTask\Application\Query\View\MetricTaskViewAssembler;
use TaskFlow\Metric\MetricTask\Application\Query\View\SearchMetricTasks;
use TaskFlow\Metric\MetricTask\Application\Query\View\SearchMetricTasksHandler;
use Tests\Double\Metric\MetricTask\Application\View\MetricTaskViewMother;
use Tests\Double\Metric\MetricTask\Domain\MetricTaskMother;
use Tests\Double\Metric\MetricTask\Domain\MetricTaskMotherRepository;
use Tests\Double\Shared\UuidMother;

final class SearchMetricTasksHandlerTest extends MetricTaskMotherRepository
{
    private SearchMetricTasksHandler | null $queryHandler;

    protected function setUp(): void
    {
        parent::setUp();

        $this->queryHandler = new SearchMetricTasksHandler(
            repository: $this->repository(),
            itemAssembler: new MetricTaskViewAssembler(),
        );
    }

    public function test_return_view(): void
    {
        $query = $this->randomQuery();

        $firstTask = MetricTaskMother::create(creatorId: $query->userId);
        $secondTask = MetricTaskMother::create(creatorId: $query->userId);

        $list = [$firstTask, $secondTask];

        $this->givenFoundByCreatorId($query->userId, $list);

        $response =
            [
                MetricTaskViewMother::create(
                    id: $firstTask->id(),
                    creatorId: $firstTask->creatorId(),
                    status: $firstTask->status(),
                    numUpdates: $firstTask->numUpdates(),
                ),
                MetricTaskViewMother::create(
                    id: $secondTask->id(),
                    creatorId: $secondTask->creatorId(),
                    status: $secondTask->status(),
                    numUpdates: $secondTask->numUpdates(),
                ),
            ];

        $this->assertAskListResponse($response, $query, $this->queryHandler);
    }

    private function randomQuery(): SearchMetricTasks
    {
        return new SearchMetricTasks(
            userId: UuidMother::create()->value(),
        );
    }
}
