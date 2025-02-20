<?php

namespace TaskFlow\Shared\Infrastructure\Symfony\Service;

use Symfony\Component\HttpFoundation\Request;
use TaskFlow\Shared\Infrastructure\Symfony\Service\Exception\RequestUnexpectedException;

final class PrimitiveExtractor
{
    private const VALID_FORMAT = 'application/json';

    public static function invoke(Request $request): array
    {
        if ($request->headers->get('Content-Type') !== self::VALID_FORMAT) {
            throw RequestUnexpectedException::invalidFormat();
        }

        $data = json_decode($request->getContent(), true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw RequestUnexpectedException::invalidFormat();
        }

        return $data;
    }
}
