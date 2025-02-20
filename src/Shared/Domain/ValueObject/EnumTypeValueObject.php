<?php

declare(strict_types=1);

namespace TaskFlow\Shared\Domain\ValueObject;

trait EnumTypeValueObject
{
    final public function value(): string
    {
        return $this->value;
    }
}
