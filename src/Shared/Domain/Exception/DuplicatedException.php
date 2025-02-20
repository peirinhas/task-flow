<?php

declare(strict_types=1);

namespace TaskFlow\Shared\Domain\Exception;

use function sprintf;

abstract class DuplicatedException extends ConflictException
{
    protected static function alreadyExistsMessage(string $name, string $identifier): string
    {
        return sprintf(
            'Cannot create a <%s> as already exists another with the same identifier: <%s>',
            $name,
            $identifier,
        );
    }
}
