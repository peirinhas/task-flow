<?php

declare(strict_types=1);

namespace TaskFlow\Core\Task\Application\Query\View;

use TaskFlow\Shared\Domain\Bus\Query\Query;

/**
 * @template-implements Query<?TaskView>
 */
final class SearchTaskById implements Query
{
    public function __construct(public string $id, public string $userId)
    {
    }
}
