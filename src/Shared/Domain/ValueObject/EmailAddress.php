<?php

declare(strict_types=1);

namespace TaskFlow\Shared\Domain\ValueObject;

use TaskFlow\Shared\Domain\Exception\UnexpectedEmailAddress;

abstract class EmailAddress extends StringValueObject
{
    final protected function __construct(string $value)
    {
        $value = strtolower($value);
        $this->guardIsValid($value);

        parent::__construct($value);
    }

    public static function isValid(string $emailAddress): bool
    {
        return false !== filter_var($emailAddress, FILTER_VALIDATE_EMAIL);
    }

    private function guardIsValid(string $emailAddress): void
    {
        if (!self::isValid($emailAddress)) {
            throw UnexpectedEmailAddress::create($emailAddress);
        }
    }
}
