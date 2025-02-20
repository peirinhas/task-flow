<?php

declare(strict_types=1);

namespace TaskFlow\Core\Task\Domain;

use TaskFlow\Shared\Domain\ValueObject\EnumTypeValueObject;

enum TaskPriority: string
{
    use EnumTypeValueObject;

    case CRITICAL = 'critical';
    case HIGH = 'high';
    case LOW = 'low';
    case MEDIUM = 'medium';

    public static function default(): self
    {
        return self::LOW;
    }
}
