<?php

declare(strict_types=1);

namespace App\Tests\Unit\Service\WorkEntry;

use App\Dto\WorkEntry\UpdateWorkEntryDto;
use App\Entity\User;
use App\Entity\WorkEntry;
use App\Repository\UserRepository;
use App\Repository\WorkEntryRepository;
use App\Service\WorkEntry\UpdateWorkEntryService;
use DateTime;
use PHPUnit\Framework\TestCase;

class UpdateWorkEntryServiceTest extends TestCase
{
    public function testExecute(): void
    {
        $userRepository = $this->createMock(UserRepository::class);
        $user = new User();
        $user->setName('foo');
        $user->setEmail('test@example.com');
        $user->setCreatedAt(new \DateTimeImmutable());
        $user->setUpdatedAt(new \DateTimeImmutable());
        $userRepository->expects($this->once())
            ->method('findUserByIdNotDeleted')
            ->willReturn($user);
        $workEntryRepository = $this->createMock(WorkEntryRepository::class);
        $updateWorkEntryDto = new UpdateWorkEntryDto(1, new DateTime);
        /** @var WorkEntry $workEntryObject */
        $workEntryObject = null;
        $workEntryRepository->expects($this->once())
            ->method('save')
            ->willReturnCallback(
                function (WorkEntry $workEntry) use (&$workEntryObject) {
                    $workEntry->setCreatedAt(new \DateTimeImmutable());
                    $workEntry->setUpdatedAt(new \DateTimeImmutable());
                    $workEntry->setStartDate(new DateTime());
                    $workEntryObject = $workEntry;
                }
            );

        $workEntryService = new UpdateWorkEntryService($userRepository, $workEntryRepository);
        $response = $workEntryService->execute(1, $updateWorkEntryDto);

        $this->assertEquals($workEntryObject->getStartDate(), $response->startDate);
    }
}
