<?php

declare(strict_types=1);

namespace TaskFlow\Core\User\Infrastructure\Persistence\Doctrine;

use TaskFlow\Core\User\Domain\User;
use TaskFlow\Core\User\Domain\UserEmailAddress;
use TaskFlow\Core\User\Domain\UserRepository;
use TaskFlow\Shared\Domain\Uuid;
use TaskFlow\Shared\Infrastructure\Persistence\Doctrine\DoctrineRepository;

final class UserDoctrineRepository extends DoctrineRepository implements UserRepository
{
    public function add(User $user): void
    {
        $this->persistAggregateRoot($user);
    }

    public function searchById(Uuid $id): ?User
    {
        return $this->repository(User::class)->find($id);
    }

    public function searchByEmail(UserEmailAddress $email): ?User
    {
        return $this->repository(User::class)->findOneBy(['email.value' => $email->value()]);
    }
}
