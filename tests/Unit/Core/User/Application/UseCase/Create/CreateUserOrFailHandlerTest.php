<?php

declare(strict_types=1);

namespace Tests\Unit\Core\User\Application\UseCase\Create;

use PHPUnit\Framework\MockObject\MockObject;
use TaskFlow\Core\User\Application\UseCase\Create\CreateUserOrFail;
use TaskFlow\Core\User\Application\UseCase\Create\CreateUserOrFailHandler;
use TaskFlow\Core\User\Domain\Exception\UserAlreadyExists;
use TaskFlow\Core\User\Domain\Exception\UserEmailAlreadyExists;
use TaskFlow\Core\User\Domain\UserEmailAddress;
use TaskFlow\Core\User\Infrastructure\Security\PasswordHasher;
use TaskFlow\Shared\Domain\Exception\UnexpectedValueException;
use Tests\Double\Core\User\Domain\UserEmailAddressMother;
use Tests\Double\Core\User\Domain\UserMother;
use Tests\Double\Core\User\Domain\UserMotherRepository;
use Tests\Double\Core\User\Domain\UserNameMother;
use Tests\Double\Core\User\Domain\UserPasswordMother;
use Tests\Double\Shared\UuidMother;

final class CreateUserOrFailHandlerTest extends UserMotherRepository
{
    private CreateUserOrFailHandler | null $handler;
    private MockObject | PasswordHasher | null $passwordHasherMock;

    protected function setUp(): void
    {
        parent::setUp();

        $this->passwordHasherMock = $this->createMock(PasswordHasher::class);

        $this->handler = new CreateUserOrFailHandler($this->repository(), $this->passwordHasherMock);
    }

    public function test_fails_when_uuid_exist(): void
    {
        $this->expectException(UserAlreadyExists::class);

        $command = $this->randomCommand();

        $user = UserMother::create(id: $command->id);
        $this->givenFoundById($command->id, $user);

        $this->thenNotAdd();

        $this->dispatch($command, $this->handler);
    }

    public function test_fails_when_email_exist(): void
    {
        $this->expectException(UserEmailAlreadyExists::class);

        $command = $this->randomCommand();

        $user = UserMother::create(email: $command->email);
        $this->givenNotFoundById($command->id);
        $this->givenFoundByEmail(email: $command->email, aggregateRoot: $user);

        $this->thenNotAdd();

        $this->dispatch($command, $this->handler);
    }

    public function test_fails_when_bad_email_format(): void
    {
        $this->expectException(UnexpectedValueException::class);

        $email = UserEmailAddressMother::createBadFormat();

        $command = $this->randomCommand($email);

        $this->givenNotFoundById($command->id);

        $this->thenNotAdd();

        $this->dispatch($command, $this->handler);
    }

    public function test_create_a_valid_user(): void
    {
        $command = $this->randomCommand();

        $user = UserMother::create(
            id: $command->id,
            name: $command->name,
            email: $command->email,
            password: $command->password,
        );
        $this->givenNotFoundById($command->id);
        $this->givenNotFoundByEmail($command->email);

        $user->changePassword(
            UserPasswordMother::createFromHash($this->passwordHasherMock->hashPassword($user, $command->password)),
        );
        $this->thenAdd($user);

        $this->dispatch($command, $this->handler);
    }

    private function randomCommand(UserEmailAddress $email = null): CreateUserOrFail
    {
        return new CreateUserOrFail(
            id: UuidMother::create(),
            name: UserNameMother::create(),
            email: $email ?? UserEmailAddressMother::create(),
            password: UserPasswordMother::create(),
        );
    }
}
