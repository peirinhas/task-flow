<?php

declare(strict_types=1);

namespace TaskFlow\Core\Task\Domain;

enum TaskStatus: string
{
    case DONE = 'done';
    case PENDING = 'pending';
    case WORKING = 'working';

    public function value(): string
    {
        return $this->value;
    }

    public static function default(): self
    {
        return self::PENDING;
    }
}
