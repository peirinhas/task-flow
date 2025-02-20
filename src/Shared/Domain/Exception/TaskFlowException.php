<?php

declare(strict_types=1);

namespace TaskFlow\Shared\Domain\Exception;

use Exception;

use function explode;
use function strtolower;

abstract class TaskFlowException extends Exception
{
    private string $name;

    protected function __construct(string $message, string $id)
    {
        parent::__construct($message);

        $this->name = 'taskFlow.' . self::boundedContext() . '.exception.' . $id;
    }

    public function name(): string
    {
        return $this->name;
    }

    private static function boundedContext(): string
    {
        $parts = explode('\\', static::class, 3);

        $context = strtolower($parts[1]);
        if ($context === '') {
            //Throw a PHP Exception to avoid possible infinite loop
            throw new Exception('Cannot extract context from exception: ' . static::class);
        }

        return $context;
    }
}
