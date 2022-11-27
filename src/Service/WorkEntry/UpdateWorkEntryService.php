<?php

declare(strict_types=1);

namespace App\Service\WorkEntry;

use App\Dto\WorkEntry\UpdateWorkEntryDto;
use App\Entity\User;
use App\Entity\WorkEntry;
use App\Exception\UserNotFoundException;
use App\Repository\UserRepository;
use App\Repository\WorkEntryRepository;
use App\Response\User\GetUserResponse;
use App\Response\WorkEntry\GetWorkEntryResponse;

final class UpdateWorkEntryService
{
    public function __construct(
        private readonly UserRepository $userRepository,
        private readonly WorkEntryRepository $workEntryRepository
    ) {
    }

    public function execute(int $id, UpdateWorkEntryDto $createWorkEntryDto): GetWorkEntryResponse
    {
        $userId = $createWorkEntryDto->userId;
        $user = $this->userRepository->findUserByIdNotDeleted($userId);

        if (!$user) {
            throw new UserNotFoundException($userId);
        }

        $workEntry = $this->workEntryRepository->findWorkEntryByIdNotDeleted($id);

        if (null === $workEntry) {
            $workEntry = new WorkEntry();
        }

        $workEntry = $this->updateWorkEntry($user, $workEntry, $createWorkEntryDto);

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

    private function updateWorkEntry(User $user, WorkEntry $workEntry, UpdateWorkEntryDto $updateWorkEntryDto): WorkEntry
    {
        $workEntry->setUser($user);
        $workEntry->setStartDate($updateWorkEntryDto->startDate);

        if ($updateWorkEntryDto->endDate) {
            $workEntry->setEndDate($updateWorkEntryDto->endDate);
        }

        return $workEntry;
    }
}
