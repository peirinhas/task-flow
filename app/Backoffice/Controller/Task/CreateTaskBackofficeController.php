<?php

declare(strict_types=1);

namespace App\Backoffice\Controller\Task;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use TaskFlow\Core\Task\Application\UseCase\Create\CreateTaskOrFail;
use TaskFlow\Core\Task\Domain\Exception\TaskAlreadyExists;
use TaskFlow\Core\Task\Domain\TaskDescription;
use TaskFlow\Core\Task\Domain\TaskPriority;
use TaskFlow\Core\Task\Domain\TaskStatus;
use TaskFlow\Core\Task\Domain\TaskTitle;
use TaskFlow\Shared\Domain\Uuid;
use TaskFlow\Shared\Domain\ValueObject\UuidValueObject;
use TaskFlow\Shared\Infrastructure\Symfony\Controller\ApiController;

final class CreateTaskBackofficeController extends ApiController
{
    #[Route(
        path: 'api/tasks/{id}',
        name: 'task.create',
        requirements: ['id' => UuidValueObject::EMBEDDED_PATTERN],
        methods: ['POST']
    )]
    public function __invoke(string $id, Request $request): JsonResponse
    {
        $data = $this->getBodyContent($request);
        $userId = $this->getUser()->id();

        $this->dispatch(
            new CreateTaskOrFail(
                id: Uuid::create($id),
                title: TaskTitle::create($data['title']),
                description: TaskDescription::create($data['description']),
                creatorId: $userId,
                priority: isset($data['priority']) ? TaskPriority::from($data['priority']) : TaskPriority::default(),
                status: TaskStatus::default(),
            ),
        );

        return new JsonResponse(["status" => "Task created successfully"], Response::HTTP_CREATED);
    }

    protected function exceptions(): array
    {
        return [
            TaskAlreadyExists::class => Response::HTTP_CONFLICT,
        ];
    }
}
