<?php

declare(strict_types=1);

namespace App\Service\WorkEntry;

use App\Dto\WorkEntry\GetWorkEntriesCollectionDto;
use App\Entity\WorkEntry;
use App\Repository\WorkEntryRepository;
use App\Response\User\GetUserResponse;
use App\Response\WorkEntry\GetWorkEntriesCollectionResponse;
use App\Response\WorkEntry\GetWorkEntryResponse;

class GetWorkEntriesCollectionService
{
    public function __construct(private readonly WorkEntryRepository $workEntryRepository)
    {
    }

    public function execute(GetWorkEntriesCollectionDto $getWorkEntriesCollectionDto): ?GetWorkEntriesCollectionResponse
    {
        $limit = $getWorkEntriesCollectionDto->limit;
        $offset = $getWorkEntriesCollectionDto->offset;
        $workEntries = $this->workEntryRepository->findWorkEntriesNotDeleted($limit, $offset);

        if (empty($workEntries)) {
            return null;
        }

        $workEntriesResponse = [];
        foreach ($workEntries as $workEntry) {
            $workEntriesResponse[] = $this->getWorkEntryResponse($workEntry);
        }

        return new GetWorkEntriesCollectionResponse(
            $limit,
            $offset,
            $workEntriesResponse,
            count($workEntriesResponse)
        );
    }

    private function getWorkEntryResponse(WorkEntry $workEntry): GetWorkEntryResponse
    {
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
