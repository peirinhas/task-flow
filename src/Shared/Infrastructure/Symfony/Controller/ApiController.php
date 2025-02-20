<?php

declare(strict_types=1);

namespace TaskFlow\Shared\Infrastructure\Symfony\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Messenger\MessageBusInterface;
use TaskFlow\Shared\Application\Query\View;
use TaskFlow\Shared\Domain\Bus\Command\Command;
use TaskFlow\Shared\Domain\Bus\Query\Query;
use TaskFlow\Shared\Infrastructure\Bus\Query\QueryBus;
use TaskFlow\Shared\Infrastructure\Symfony\Service\PrimitiveExtractor;

use function Lambdish\Phunctional\each;

abstract class ApiController extends AbstractController
{
    public function __construct(
        private readonly QueryBus $queryBus,
        private readonly MessageBusInterface $commandBus,
        private readonly PrimitiveExtractor $primitiveExtractor,
        ApiExceptionsHttpStatusCodeMapping $exceptionHandler,
    ) {
        each(
            fn(int $httpCode, string $exceptionClass) => $exceptionHandler->register($exceptionClass, $httpCode),
            $this->exceptions(),
        );
    }

    abstract protected function exceptions(): array;

    /**
     * @return list<mixed>|View|null
     */
    protected function ask(Query $query): null | array | View
    {
        return $this->queryBus->ask($query);
    }

    protected function dispatch(Command $command): void
    {
        $this->commandBus->dispatch($command);
    }

    /** @return array<mixed> */
    protected function getBodyContent(Request $request): array
    {
        return $this->primitiveExtractor::invoke($request);
    }
}
