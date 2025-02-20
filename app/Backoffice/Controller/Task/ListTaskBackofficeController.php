<?php

declare(strict_types=1);

namespace App\Backoffice\Controller\Task;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use TaskFlow\Core\Task\Application\Query\View\SearchTasks;
use TaskFlow\Shared\Infrastructure\Symfony\Controller\ApiController;

final class ListTaskBackofficeController extends ApiController
{
    #[Route(
        path: 'api/tasks',
        name: 'task.list',
        methods: ['GET'],

    )]
    public function __invoke(): JsonResponse
    {
        return new JsonResponse(
            $this->ask(
                new SearchTasks($this->getUser()->id()->value()),
            ),
        );
    }

    protected function exceptions(): array
    {
        return [];
    }
}
