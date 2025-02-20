<?php

declare(strict_types=1);

namespace TaskFlow\Shared\Domain\Exception;

abstract class UnexpectedValueException extends TaskFlowException
{
    protected static function invalidFormatMessage(string $entityName, string $message = 'Unknown error'): string
    {
        return "Not a valid <$entityName>. Message: $message";
    }
}
