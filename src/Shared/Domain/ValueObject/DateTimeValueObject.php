<?php

declare(strict_types=1);

namespace TaskFlow\Shared\Domain\ValueObject;

use DateTimeImmutable;
use DateTimeInterface;
use DateTimeZone;

/** @psalm-immutable */
abstract class DateTimeValueObject
{
    protected DateTimeImmutable $value;

    public function __construct(string $datetime, ?DateTimeZone $timezone = null)
    {
        $this->value = new DateTimeImmutable($datetime, $timezone);
    }

    public function value(): DateTimeImmutable
    {
        return $this->value;
    }

    public function atomFormatted(): string
    {
        return $this->value->format(DateTimeInterface::ATOM);
    }
}
