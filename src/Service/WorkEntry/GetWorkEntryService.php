<?php

declare(strict_types=1);

namespace App\Service\WorkEntry;

use App\Exception\WorkEntryNotFoundException;
use App\Repository\WorkEntryRepository;
use App\Response\User\GetUserResponse;
use App\Response\WorkEntry\GetWorkEntryResponse;

final class GetWorkEntryService
{
    public function __construct(private readonly WorkEntryRepository $workEntryRepository)
    {
    }

    public function execute(int $id): GetWorkEntryResponse
    {
        $workEntry = $this->workEntryRepository->findWorkEntryByIdNotDeleted($id);

        if (!$workEntry) {
            throw new WorkEntryNotFoundException($id);
        }

        $user = $workEntry->getUser();
        $userResponse = new GetUserResponse(
            $user->getId(),
            $user->getName(),
            $user->getEmail(),
            $user->getCreatedAt(),
            $user->getUpdatedAt()
        );

        return new GetWorkEntryResponse(
            $workEntry->getId(),
            [$userResponse],
            $workEntry->getCreatedAt(),
            $workEntry->getUpdatedAt(),
            $workEntry->getStartDate(),
            $workEntry->getEndDate(),
        );
    }
}
