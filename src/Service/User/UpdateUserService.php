<?php

declare(strict_types=1);

namespace App\Service\User;

use App\Dto\User\UpdateUserDto;
use App\Entity\User;
use App\Repository\UserRepository;
use App\Response\User\GetUserResponse;

final class UpdateUserService
{
    public function __construct(private readonly UserRepository $userRepository)
    {
    }

    public function execute(int $id, UpdateUserDto $updateUserDto): GetUserResponse
    {
        $user = $this->userRepository->findUserByIdNotDeleted($id);

        if (null === $user) {
            $user = new User();
        }

        $user = $this->updateUser($user, $updateUserDto);

        $this->userRepository->save($user, true);

        return new GetUserResponse(
            $user->getId(),
            $user->getName(),
            $user->getEmail(),
            $user->getCreatedAt(),
            $user->getUpdatedAt()
        );
    }

    private function updateUser(User $user, UpdateUserDto $updateUserDto): User
    {
        $user->setEmail($updateUserDto->email);
        $user->setName($updateUserDto->name);

        return $user;
    }
}
