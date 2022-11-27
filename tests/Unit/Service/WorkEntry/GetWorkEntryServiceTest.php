<?php

declare(strict_types=1);

namespace App\Tests\Unit\Service\WorkEntry;

use App\Entity\User;
use App\Entity\WorkEntry;
use App\Exception\WorkEntryNotFoundException;
use App\Repository\WorkEntryRepository;
use App\Response\WorkEntry\GetWorkEntryResponse;
use App\Service\WorkEntry\GetWorkEntryService;
use PHPUnit\Framework\TestCase;

class GetWorkEntryServiceTest extends TestCase
{
    public function testExecute(): void
    {
        $workEntryRepository = $this->createMock(WorkEntryRepository::class);
        $workEntry = new WorkEntry();
        $user = new User();
        $user->setName('foo');
        $user->setEmail('test@example.com');
        $user->setCreatedAt(new \DateTimeImmutable());
        $user->setUpdatedAt(new \DateTimeImmutable());
        $workEntry->setUser($user);
        $workEntry->setStartDate(new \DateTime());
        $workEntry->setCreatedAt(new \DateTimeImmutable());
        $workEntry->setUpdatedAt(new \DateTimeImmutable());

        $workEntryRepository->expects($this->once())
            ->method('findWorkEntryByIdNotDeleted')
            ->willReturn($workEntry);

        $getWorkEntryService = new GetWorkEntryService($workEntryRepository);
        $response = $getWorkEntryService->execute(1);

        $this->assertInstanceOf(GetWorkEntryResponse::class, $response);
    }

    public function testExecuteNotFound(): void
    {
        $workEntryRepository = $this->createMock(WorkEntryRepository::class);

        $workEntryRepository->expects($this->once())
            ->method('findWorkEntryByIdNotDeleted')
            ->willReturn(null);

        $getWorkEntryService = new GetWorkEntryService($workEntryRepository);

        $this->expectException(WorkEntryNotFoundException::class);
        $getWorkEntryService->execute(1);
    }
}
