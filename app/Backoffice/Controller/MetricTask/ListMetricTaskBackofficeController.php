<?php

declare(strict_types=1);

namespace App\Backoffice\Controller\MetricTask;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use TaskFlow\Metric\MetricTask\Application\Query\View\SearchMetricTasks;
use TaskFlow\Shared\Infrastructure\Symfony\Controller\ApiController;

final class ListMetricTaskBackofficeController extends ApiController
{
    #[Route(
        path: 'api/metric-tasks',
        name: 'metric_task.list',
        methods: ['GET'],

    )]
    public function __invoke(): JsonResponse
    {
        return new JsonResponse(
            $this->ask(
                new SearchMetricTasks($this->getUser()->id()->value()),
            ),
        );
    }

    protected function exceptions(): array
    {
        return [];
    }
}
