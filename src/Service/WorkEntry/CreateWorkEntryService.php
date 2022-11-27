<?php

declare(strict_types=1);

namespace App\Service\WorkEntry;

use App\Dto\WorkEntry\CreateWorkEntryDto;
use App\Entity\User;
use App\Entity\WorkEntry;
use App\Exception\UserNotFoundException;
use App\Repository\UserRepository;
use App\Repository\WorkEntryRepository;
use App\Response\User\GetUserResponse;
use App\Response\WorkEntry\GetWorkEntryResponse;

class CreateWorkEntryService
{
    public function __construct(
        private readonly UserRepository $userRepository,
        private readonly WorkEntryRepository $workEntryRepository
    ) {
    }

    public function execute(CreateWorkEntryDto $createWorkEntryDto): GetWorkEntryResponse
    {
        $userId = $createWorkEntryDto->userId;
        $user = $this->userRepository->findOneBy(['id' => $userId]);

        if (!$user) {
            throw new UserNotFoundException($userId);
        }

        $workEntry = $this->createWorkEntry($user, $createWorkEntryDto);
        $this->workEntryRepository->save($workEntry, true);

        $userResponse = $this->getUserResponse($user);

        return new GetWorkEntryResponse(
            $workEntry->getId(),
            [$userResponse],
            $workEntry->getCreatedAt(),
            $workEntry->getUpdatedAt(),
            $workEntry->getStartDate(),
            $workEntry->getEndDate()
        );
    }

    private function getUserResponse(User $user): GetUserResponse
    {
        return new GetUserResponse(
            $user->getId(),
            $user->getName(),
            $user->getEmail(),
            $user->getCreatedAt(),
            $user->getUpdatedAt()
        );
    }

    private function createWorkEntry(User $user, CreateWorkEntryDto $createWorkEntryDto): WorkEntry
    {
        $workEntry = new WorkEntry();
        $workEntry->setUser($user);
        $workEntry->setStartDate($createWorkEntryDto->startDate);

        if ($createWorkEntryDto->endDate) {
            $workEntry->setEndDate($createWorkEntryDto->endDate);
        }

        return $workEntry;
    }
}
