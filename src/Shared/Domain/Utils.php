<?php

declare(strict_types=1);

namespace TaskFlow\Shared\Domain;

use DateTimeInterface;

final class Utils
{
    public static function dateToString(DateTimeInterface $date): string
    {
        return $date->format(DateTimeInterface::ATOM);
    }
}
