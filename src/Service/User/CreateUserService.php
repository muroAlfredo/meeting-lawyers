<?php

declare(strict_types=1);

namespace App\Service\User;

use App\Dto\User\CreateUserDto;
use App\Entity\User;
use App\Repository\UserRepository;
use App\Response\User\GetUserResponse;

final class CreateUserService
{
    public function __construct(private readonly UserRepository $userRepository)
    {
    }

    public function execute(CreateUserDto $createUserDto): GetUserResponse
    {
        $user = $this->createUser($createUserDto);

        $this->userRepository->save($user, true);

        return new GetUserResponse(
            $user->getId(),
            $user->getName(),
            $user->getEmail(),
            $user->getCreatedAt(),
            $user->getUpdatedAt()
        );
    }

    private function createUser(CreateUserDto $createUserDto): User
    {
        $user = new User();
        $user->setEmail($createUserDto->email);
        $user->setName($createUserDto->name);

        return $user;
    }
}
