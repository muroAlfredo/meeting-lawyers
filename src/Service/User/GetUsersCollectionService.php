<?php

declare(strict_types=1);

namespace App\Service\User;

use App\Dto\User\GetUsersCollectionDto;
use App\Repository\UserRepository;
use App\Response\User\GetUserResponse;
use App\Response\User\GetUsersCollectionResponse;

final class GetUsersCollectionService
{
    public function __construct(private readonly UserRepository $userRepository)
    {
    }

    public function execute(GetUsersCollectionDto $getUsersCollectionDto): ?GetUsersCollectionResponse
    {
        $limit = $getUsersCollectionDto->limit;
        $offset = $getUsersCollectionDto->offset;
        $users = $this->userRepository->findUsersNotDeleted($limit, $offset);

        if (empty($users)) {
            return null;
        }

        $usersResponse = [];
        foreach ($users as $user) {
            $userResponse = new GetUserResponse(
                $user->getId(),
                $user->getName(),
                $user->getEmail(),
                $user->getCreatedAt(),
                $user->getUpdatedAt()
            );
            $usersResponse[] = $userResponse;
        }

        return new GetUsersCollectionResponse(
            $limit,
            $offset,
            $usersResponse,
            count($users)
        );
    }
}
