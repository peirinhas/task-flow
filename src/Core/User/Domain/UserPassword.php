<?php

declare(strict_types=1);

namespace TaskFlow\Core\User\Domain;

use TaskFlow\Core\User\Domain\Exception\UserPasswordInvalidFormat;
use TaskFlow\Shared\Domain\ValueObject\StringValueObject;

final class UserPassword extends StringValueObject
{
    private const MIN_LENGTH = 8;
    private const PASSWORD_REGEX = "/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d).{8,}$/";

    private function __construct(string $value)
    {
        parent::__construct($value);
    }

    public static function create(string $value): self
    {
        self::guardIsValid($value);
        return new self($value);
    }

    public static function createFromHash(string $value): self
    {
        return new self($value);
    }

    private static function guardIsValid(string $value): void
    {
        if (strlen($value) < self::MIN_LENGTH || !preg_match(self::PASSWORD_REGEX, $value)) {
            throw UserPasswordInvalidFormat::create($value, self::MIN_LENGTH);
        }
    }
}
