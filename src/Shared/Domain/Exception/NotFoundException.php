<?php

declare(strict_types=1);

namespace TaskFlow\Shared\Domain\Exception;

abstract class NotFoundException extends TaskFlowException
{
    protected static function notFoundMessage(string $searched, ?string $criteria = null): string
    {
        return ($criteria)
            ? "<$searched> not found when searching by criteria <$criteria>"
            : "<$searched> not found";
    }
}
