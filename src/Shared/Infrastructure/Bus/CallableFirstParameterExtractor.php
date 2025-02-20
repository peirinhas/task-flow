<?php

declare(strict_types=1);

namespace TaskFlow\Shared\Infrastructure\Bus;

use TaskFlow\Shared\Domain\Bus\Event\DomainEventSubscriber;

use function Lambdish\Phunctional\reduce;

final class CallableFirstParameterExtractor
{
    public static function forPipedCallables(iterable $callables): array
    {
        return reduce(self::pipedCallablesReducer(), $callables, []);
    }

    private static function pipedCallablesReducer(): callable
    {
        return static function (array $subscribers, DomainEventSubscriber $subscriber): array {
            $subscribedEvents = $subscriber::subscribedTo();

            foreach ($subscribedEvents as $subscribedEvent) {
                $subscribers[$subscribedEvent][] = $subscriber;
            }

            return $subscribers;
        };
    }
}
