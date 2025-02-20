<?php

namespace TaskFlow\Shared\Infrastructure\Symfony\Service\Exception;

use TaskFlow\Shared\Domain\Exception\UnexpectedValueException;

final class RequestUnexpectedException extends UnexpectedValueException
{
    public static function invalidFormat(): self
    {
        return new self(
            "Request body or header is invalid",
            'request.invalid',
        );
    }
}
