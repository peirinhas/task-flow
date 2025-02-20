<?php

declare(strict_types=1);

namespace TaskFlow\Core\Task\Application\Query\View;

use TaskFlow\Shared\Domain\Bus\Query\Query;

final class SearchTasks implements Query
{
    public function __construct(public string $userId)
    {
    }
}
