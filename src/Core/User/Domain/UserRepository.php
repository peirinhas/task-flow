<?php

declare(strict_types=1);

namespace TaskFlow\Core\User\Domain;

use TaskFlow\Shared\Domain\Uuid;

interface UserRepository
{
    public function add(User $user): void;

    public function searchById(Uuid $id): ?User;

    public function searchByEmail(UserEmailAddress $email): ?User;
}
