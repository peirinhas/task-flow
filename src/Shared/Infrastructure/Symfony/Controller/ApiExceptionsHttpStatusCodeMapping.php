<?php

declare(strict_types=1);

namespace TaskFlow\Shared\Infrastructure\Symfony\Controller;

use InvalidArgumentException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

final class ApiExceptionsHttpStatusCodeMapping
{
    private array $exceptions = [
        InvalidArgumentException::class => Response::HTTP_BAD_REQUEST,
        NotFoundHttpException::class => Response::HTTP_NOT_FOUND,
    ];

    public function register(string $exceptionClass, int $statusCode): void
    {
        $this->exceptions[$exceptionClass] = $statusCode;
    }
}
