<?php

declare(strict_types=1);

namespace App\Tests\Unit\Service\WorkEntry;

use App\Dto\WorkEntry\GetWorkEntriesCollectionDto;
use App\Entity\User;
use App\Entity\WorkEntry;
use App\Repository\WorkEntryRepository;
use App\Response\WorkEntry\GetWorkEntriesCollectionResponse;
use App\Service\WorkEntry\GetWorkEntriesCollectionService;
use PHPUnit\Framework\TestCase;

class GetWorkEntriesCollectionServiceTest extends TestCase
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
            ->method('findWorkEntriesNotDeleted')
            ->willReturn([$workEntry]);

        $workEntriesCollectionDto = new GetWorkEntriesCollectionDto(10, 0);

        $getWorkEntriesService = new GetWorkEntriesCollectionService($workEntryRepository);
        $response = $getWorkEntriesService->execute($workEntriesCollectionDto);

        $this->assertInstanceOf(GetWorkEntriesCollectionResponse::class, $response);
    }

    public function testExecuteNotFound(): void
    {
        $workEntryRepository = $this->createMock(WorkEntryRepository::class);

        $workEntryRepository->expects($this->once())
            ->method('findWorkEntriesNotDeleted')
            ->willReturn([]);

        $workEntriesCollectionDto = new GetWorkEntriesCollectionDto(10, 0);

        $getWorkEntriesService = new GetWorkEntriesCollectionService($workEntryRepository);
        $response = $getWorkEntriesService->execute($workEntriesCollectionDto);

        $this->assertEmpty($response);
    }
}
