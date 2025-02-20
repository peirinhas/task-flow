<?php

declare(strict_types=1);

namespace App\Backoffice\Controller\Task;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use TaskFlow\Core\Task\Application\UseCase\Remove\RemoveTaskOrFail;
use TaskFlow\Core\Task\Domain\Exception\TaskNotFound;
use TaskFlow\Core\Task\Domain\Exception\TaskOwnershipException;
use TaskFlow\Shared\Domain\Uuid;
use TaskFlow\Shared\Domain\ValueObject\UuidValueObject;
use TaskFlow\Shared\Infrastructure\Symfony\Controller\ApiController;

final class RemoveTaskBackofficeController extends ApiController
{
    #[Route(
        path: 'api/tasks/{id}',
        name: 'task.remove',
        requirements: ['id' => UuidValueObject::EMBEDDED_PATTERN],
        methods: ['DELETE']
    )]
    public function __invoke(string $id, Request $request): JsonResponse
    {
        $this->dispatch(
            new RemoveTaskOrFail(
                id: Uuid::create($id),
                userId: $this->getUser()->id(),
            ),
        );

        return new JsonResponse(["status" => "Task removed successfully"], Response::HTTP_OK);
    }

    protected function exceptions(): array
    {
        return [
            TaskNotFound::class => Response::HTTP_NOT_FOUND,
            TaskOwnershipException::class => Response::HTTP_FORBIDDEN
        ];
    }
}
