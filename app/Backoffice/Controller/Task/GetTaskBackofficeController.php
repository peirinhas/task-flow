<?php

declare(strict_types=1);

namespace App\Backoffice\Controller\Task;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;
use TaskFlow\Core\Task\Application\Query\View\SearchTaskViewByIdFinder;
use TaskFlow\Core\Task\Domain\Exception\TaskNotFound;
use TaskFlow\Core\Task\Domain\Exception\TaskOwnershipException;
use TaskFlow\Shared\Domain\ValueObject\UuidValueObject;
use TaskFlow\Shared\Infrastructure\Bus\Query\QueryBus;
use TaskFlow\Shared\Infrastructure\Symfony\Controller\ApiController;
use TaskFlow\Shared\Infrastructure\Symfony\Controller\ApiExceptionsHttpStatusCodeMapping;
use TaskFlow\Shared\Infrastructure\Symfony\Service\PrimitiveExtractor;

final class GetTaskBackofficeController extends ApiController
{
    public function __construct(
        QueryBus $queryBus,
        MessageBusInterface $commandBus,
        PrimitiveExtractor $primitiveExtractor,
        ApiExceptionsHttpStatusCodeMapping $exceptionHandler,
    ) {
        $this->finder = new SearchTaskViewByIdFinder($queryBus);
        parent::__construct($queryBus, $commandBus, $primitiveExtractor, $exceptionHandler);
    }

    #[Route(
        path: 'api/tasks/{id}',
        name: 'task.get',
        requirements: ['id' => UuidValueObject::EMBEDDED_PATTERN],
        methods: ['GET'],

    )]
    public function __invoke(string $id): JsonResponse
    {
        return new JsonResponse(
            $this->finder->invoke($id, $this->getUser()->id()->value()),
        );
    }

    protected function exceptions(): array
    {
        return [
            TaskNotFound::class => Response::HTTP_NOT_FOUND,
            TaskOwnershipException::class => Response::HTTP_FORBIDDEN,
        ];
    }
}
