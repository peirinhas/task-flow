<?php

declare(strict_types=1);

namespace App\Public\Controller\User;

use TaskFlow\Shared\Domain\Exception\UnexpectedEmailAddress;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use TaskFlow\Core\User\Application\UseCase\Create\CreateUserOrFail;
use TaskFlow\Core\User\Domain\Exception\UserAlreadyExists;
use TaskFlow\Core\User\Domain\Exception\UserEmailAlreadyExists;
use TaskFlow\Core\User\Domain\UserEmailAddress;
use TaskFlow\Core\User\Domain\UserName;
use TaskFlow\Core\User\Domain\UserPassword;
use TaskFlow\Shared\Domain\Uuid;
use TaskFlow\Shared\Domain\ValueObject\UuidValueObject;
use TaskFlow\Shared\Infrastructure\Symfony\Controller\ApiController;
use Symfony\Component\PasswordHasher\Exception\InvalidPasswordException;

final class CreateUserPublicController extends ApiController
{
    #[Route(
        path: 'api/users/{id}',
        name: 'user.create',
        requirements: ['id' => UuidValueObject::EMBEDDED_PATTERN],
        methods: ['POST']
    )]
    public function __invoke(string $id, Request $request): JsonResponse
    {
        $data = $this->getBodyContent($request);

        $this->dispatch(
            new CreateUserOrFail(
                id: Uuid::create($id),
                name: UserName::create($data['name']),
                email: UserEmailAddress::create($data['email']),
                password: UserPassword::create($data['password']),
            ),
        );

        return new JsonResponse(["status" => "User created successfully"], Response::HTTP_CREATED);
    }

    protected function exceptions(): array
    {
        return [
            UserEmailAlreadyExists::class => Response::HTTP_CONFLICT,
            UserAlreadyExists::class => Response::HTTP_CONFLICT,
            InvalidPasswordException::class => Response::HTTP_UNPROCESSABLE_ENTITY,
            UnexpectedEmailAddress::class => Response::HTTP_UNPROCESSABLE_ENTITY,
        ];
    }
}
