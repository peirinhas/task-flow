<?php

declare(strict_types=1);

namespace Tests\Shared\Infrastructure\PhpUnit;

use Mockery;
use Mockery\Adapter\Phpunit\MockeryTestCase;
use Mockery\MockInterface;
use TaskFlow\Shared\Application\Query\View;
use TaskFlow\Shared\Domain\Bus\Command\Command;
use TaskFlow\Shared\Domain\Bus\Event\DomainEvent;
use TaskFlow\Shared\Domain\Bus\Event\EventBus;
use TaskFlow\Shared\Domain\Bus\Query\Query;
use Tests\Shared\Domain\TestUtils;
use Tests\Shared\Infrastructure\Mockery\TaskFlowMatcherIsSimilar;
use Throwable;

abstract class UnitTestCase extends MockeryTestCase
{
    private EventBus | MockInterface | null $eventBus = null;

    protected function mock(string $className): MockInterface
    {
        return Mockery::mock($className);
    }

    protected function shouldPublishDomainEvent(DomainEvent $domainEvent): void
    {
        $this->eventBus()
            ->shouldReceive('publish')
            ->with($this->similarTo($domainEvent))
            ->andReturnNull();
    }

    protected function shouldNotPublishDomainEvent(): void
    {
        $this->eventBus()
            ->shouldReceive('publish')
            ->withNoArgs()
            ->andReturnNull();
    }

    protected function eventBus(): EventBus | MockInterface
    {
        return $this->eventBus ??= $this->mock(EventBus::class);
    }

    protected function dispatch(Command $command, callable $commandHandler): void
    {
        $commandHandler($command);
    }

    protected function assertAskResponse(null | View $expected, Query $query, callable $queryHandler): void
    {
        $actual = $queryHandler($query);

        $this->assertEquals($expected, $actual);
    }

    /**
     * @template T of mixed
     * @psalm-param Query<T> $query
     * @psalm-param list<T> $expected
     * @param list<T> $expected
     */
    protected function assertAskListResponse(null | array $expected, Query $query, callable $queryHandler): void
    {
        $actual = $queryHandler($query);

        $this->assertEquals($expected, $actual);
    }

    /** @param class-string<Throwable> $expectedErrorClass */
    protected function assertAskThrowsException(string $expectedErrorClass, Query $query, callable $queryHandler): void
    {
        $this->expectException($expectedErrorClass);

        $queryHandler($query);
    }

    protected function isSimilar(mixed $expected, mixed $actual): bool
    {
        return TestUtils::isSimilar($expected, $actual);
    }

    protected function assertSimilar(mixed $expected, mixed $actual): void
    {
        TestUtils::assertSimilar($expected, $actual);
    }

    protected function similarTo(mixed $value, float $delta = 0.0): TaskFlowMatcherIsSimilar
    {
        return TestUtils::similarTo($value, $delta);
    }
}
