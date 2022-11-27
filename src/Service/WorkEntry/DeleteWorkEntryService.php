<?php

declare(strict_types=1);

namespace App\Service\WorkEntry;

use App\Exception\WorkEntryNotFoundException;
use App\Repository\WorkEntryRepository;

final class DeleteWorkEntryService
{
    public function __construct(private readonly WorkEntryRepository $workEntryRepository)
    {
    }

    public function execute(int $id): void
    {
        $workEntry = $this->workEntryRepository->findWorkEntryByIdNotDeleted($id);

        if (!$workEntry) {
            throw new WorkEntryNotFoundException($id);
        }

        $workEntry->setDeletedAt(new \DateTimeImmutable());

        $this->workEntryRepository->save($workEntry, true);
    }
}
