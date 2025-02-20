<?php

declare(strict_types=1);

namespace Tests\Double\Core\User\Domain;

use Mockery\MockInterface;
use TaskFlow\Core\User\Domain\User;
use TaskFlow\Core\User\Domain\UserEmailAddress;
use TaskFlow\Core\User\Domain\UserRepository;
use TaskFlow\Shared\Domain\Uuid;
use Tests\Shared\Infrastructure\PhpUnit\UnitTestCase;

abstract class UserMotherRepository extends UnitTestCase
{
    private UserRepository | MockInterface | null $repository = null;

    protected function thenAdd(User $user): void
    {
        $this->repository()
            ->shouldReceive('add')
            ->with($this->similarTo($user))
            ->once()
            ->andReturnNull();
    }

    public function thenNotAdd(): void
    {
        $this->repository()
            ->shouldNotReceive('add');
    }

    protected function givenFoundById(Uuid $id, User $aggregateRoot): void
    {
        $this->repository()
            ->shouldReceive('searchById')
            ->with(
                self::similarTo($id),
            )
            ->andReturn($aggregateRoot);
    }

    protected function givenNotFoundById(Uuid $id): void
    {
        $this->repository()
            ->shouldReceive('searchById')
            ->with(
                self::similarTo($id),
            )
            ->andReturnNull();
    }

    protected function givenFoundByEmail(UserEmailAddress $email, User $aggregateRoot): void
    {
        $this->repository()
            ->shouldReceive('searchByEmail')
            ->with(
                self::similarTo($email),
            )
            ->andReturn($aggregateRoot);
    }

    protected function givenNotFoundByEmail(UserEmailAddress $email): void
    {
        $this->repository()
            ->shouldReceive('searchByEmail')
            ->with(
                self::similarTo($email),
            )
            ->andReturnNull();
    }

    protected function repository(): UserRepository | MockInterface
    {
        return $this->repository ??= $this->mock(UserRepository::class);
    }
}
