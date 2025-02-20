<?php

declare(strict_types=1);

namespace TaskFlow\Shared\Infrastructure\Bus\Query;

use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;
use TaskFlow\Shared\Application\Query\View;
use TaskFlow\Shared\Domain\Bus\Query\Query;

final class QueryBus
{
    use HandleTrait;

    public function __construct(
        private readonly MessageBusInterface $queryBus,
    ) {
    }

    /**
     * @template T of View|null|bool
     * @psalm-param Query<T> $query
     * @return T
     */
    public function ask(Query $query): null | array | View
    {
        $this->messageBus = $this->queryBus;
        return $this->handle($query);
    }
}
