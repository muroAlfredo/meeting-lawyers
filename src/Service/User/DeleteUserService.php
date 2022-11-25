<?php

declare(strict_types=1);

namespace App\Service\User;

use App\Exception\UserNotFoundException;
use App\Repository\UserRepository;

final class DeleteUserService
{
    public function __construct(private readonly UserRepository $userRepository)
    {
    }

    public function execute(int $id): void
    {
        $user = $this->userRepository->findUserByIdNotDeleted($id);

        if (!$user) {
            throw new UserNotFoundException($id);
        }

        $user->setDeletedAt(new \DateTimeImmutable());

        $this->userRepository->save($user, true);
    }
}
