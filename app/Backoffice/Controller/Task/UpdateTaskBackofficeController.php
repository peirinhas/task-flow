<?php

declare(strict_types=1);

namespace App\Backoffice\Controller\Task;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use TaskFlow\Core\Task\Application\UseCase\Update\UpdateTaskOrFail;
use TaskFlow\Core\Task\Domain\Exception\TaskNotFound;
use TaskFlow\Core\Task\Domain\Exception\TaskOwnershipException;
use TaskFlow\Core\Task\Domain\TaskDescription;
use TaskFlow\Core\Task\Domain\TaskPriority;
use TaskFlow\Core\Task\Domain\TaskStatus;
use TaskFlow\Core\Task\Domain\TaskTitle;
use TaskFlow\Shared\Domain\Uuid;
use TaskFlow\Shared\Domain\ValueObject\UuidValueObject;
use TaskFlow\Shared\Infrastructure\Symfony\Controller\ApiController;

final class UpdateTaskBackofficeController extends ApiController
{
    #[Route(
        path: 'api/tasks/{id}',
        name: 'task.update',
        requirements: ['id' => UuidValueObject::EMBEDDED_PATTERN],
        methods: ['PUT']
    )]
    public function __invoke(string $id, Request $request): JsonResponse
    {
        $data = $this->getBodyContent($request);

        $this->dispatch(
            new UpdateTaskOrFail(
                id: Uuid::create($id),
                title: TaskTitle::create($data['title']),
                description: TaskDescription::create($data['description']),
                userId: $this->getUser()->id(),
                priority: isset($data['priority']) ? TaskPriority::from($data['priority']) : TaskPriority::default(),
                status: isset($data['status']) ? TaskStatus::from($data['status']) : TaskStatus::default(),
            ),
        );

        return new JsonResponse(["status" => "Task updated successfully"], Response::HTTP_OK);
    }

    protected function exceptions(): array
    {
        return [
            TaskNotFound::class => Response::HTTP_NOT_FOUND,
            TaskOwnershipException::class => Response::HTTP_FORBIDDEN,
        ];
    }
}
