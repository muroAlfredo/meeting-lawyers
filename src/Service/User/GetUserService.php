<?php

declare(strict_types=1);

namespace App\Service\User;

use App\Exception\UserNotFoundException;
use App\Repository\UserRepository;
use App\Response\User\GetUserResponse;

final class GetUserService
{
    public function __construct(private readonly UserRepository $userRepository)
    {
    }

    public function execute(int $id): GetUserResponse
    {
        $user = $this->userRepository->findUserByIdNotDeleted($id);

        if (!$user) {
            throw new UserNotFoundException($id);
        }

        return new GetUserResponse(
            $user->getId(),
            $user->getName(),
            $user->getEmail(),
            $user->getCreatedAt(),
            $user->getUpdatedAt()
        );
    }
}
