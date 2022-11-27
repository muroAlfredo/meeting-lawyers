<?php

declare(strict_types=1);

namespace App\Tests\Unit\Service\WorkEntry;

use App\Entity\WorkEntry;
use App\Exception\WorkEntryNotFoundException;
use App\Repository\WorkEntryRepository;
use App\Service\WorkEntry\DeleteWorkEntryService;
use PHPUnit\Framework\TestCase;

class DeleteWorkEntryServiceTest extends TestCase
{
    public function testExecute(): void
    {
        $workEntryRepository = $this->createMock(WorkEntryRepository::class);

        $workEntryRepository->expects($this->once())
            ->method('findWorkEntryByIdNotDeleted')
            ->willReturn(new WorkEntry());

        $deleteUserService = new DeleteWorkEntryService($workEntryRepository);
        $deleteUserService->execute(1);

        $this->assertTrue(true);
    }

    public function testExecuteNotFound(): void
    {
        $workEntryRepository = $this->createMock(WorkEntryRepository::class);

        $workEntryRepository->expects($this->once())
            ->method('findWorkEntryByIdNotDeleted')
            ->willReturn(null);

        $deleteUserService = new DeleteWorkEntryService($workEntryRepository);

        $this->expectException(WorkEntryNotFoundException::class);
        $deleteUserService->execute(1);
    }
}
