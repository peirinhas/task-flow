<?php

declare(strict_types=1);

namespace TaskFlow\Core\Task\Infrastructure\Persistence\Doctrine\DBAL;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Platforms\MySQLPlatform;
use Doctrine\DBAL\Types\Type;
use TaskFlow\Core\Task\Domain\TaskPriority;

class TaskPriorityDbType extends Type
{
    public const NAME = 'task_priority_db_type';

    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform): string
    {
        if ($platform instanceof MySQLPlatform) {
            return 'VARCHAR(30)';
        }

        return $platform->getBinaryTypeDeclarationSQL($fieldDeclaration);
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): mixed
    {
        if ($value === null) {
            return null;
        }

        return TaskPriority::from($value);
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform): mixed
    {
        if ($value === null) {
            return null;
        }

        return $value->value();
    }

    public function getName(): string
    {
        return self::NAME;
    }

    public function requiresSQLCommentHint(AbstractPlatform $platform): bool
    {
        return true;
    }
}
