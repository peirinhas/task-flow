<?php

declare(strict_types=1);

namespace TaskFlow\Core\User\Application\UseCase\Create;

use TaskFlow\Core\User\Domain\Exception\UserAlreadyExists;
use TaskFlow\Core\User\Domain\Exception\UserEmailAlreadyExists;
use TaskFlow\Core\User\Domain\User;
use TaskFlow\Core\User\Domain\UserPassword;
use TaskFlow\Core\User\Domain\UserRepository;
use TaskFlow\Core\User\Infrastructure\Security\PasswordHasher;
use TaskFlow\Shared\Domain\Bus\Command\CommandHandler;
use TaskFlow\Shared\Domain\Uuid;
use TaskFlow\Shared\Domain\ValueObject\EmailAddress;

final class CreateUserOrFailHandler implements CommandHandler
{
    public function __construct(
        private readonly UserRepository $repository,
        private readonly PasswordHasher $passwordHasher,
    ) {
    }

    public function __invoke(CreateUserOrFail $command): void
    {
        $this->guardUserIdExist($command->id);
        $this->guardEmailIsUnique($command->email);

        $aggregate = User::create(
            id: $command->id,
            name: $command->name,
            email: $command->email,
            password: $command->password,
        );

        $plainHash = $this->hashPassword($aggregate, $command->password);

        $aggregate->changePassword(UserPassword::createFromHash($plainHash));

        $this->repository->add($aggregate);
    }

    private function guardUserIdExist(Uuid $id): void
    {
        if ($this->repository->searchById($id) !== null) {
            throw UserAlreadyExists::create($id);
        }
    }

    private function guardEmailIsUnique(EmailAddress $email): void
    {
        if ($this->repository->searchByEmail($email) !== null) {
            throw UserEmailAlreadyExists::create($email->value());
        }
    }

    private function hashPassword(User $user, UserPassword $passwordPlain): string
    {
        return $this->passwordHasher->hashPassword($user, $passwordPlain);
    }
}
