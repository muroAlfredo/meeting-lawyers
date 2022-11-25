<?php

declare(strict_types=1);

namespace App\Tests\Unit\Service\User;

use App\Dto\User\GetUsersCollectionDto;
use App\Entity\User;
use App\Repository\UserRepository;
use App\Response\User\GetUsersCollectionResponse;
use App\Service\User\GetUsersCollectionService;
use PHPUnit\Framework\TestCase;

class GetUsersCollectionServiceTest extends TestCase
{
    public function testExecute(): void
    {
        $userRepository = $this->createMock(UserRepository::class);
        $user = new User();
        $user->setName('testExecute');
        $user->setEmail('testExecute@example.com');
        $user->setCreatedAt(new \DateTimeImmutable());
        $user->setUpdatedAt(new \DateTimeImmutable());
        $userRepository->expects($this->once())
            ->method('findUsersNotDeleted')
            ->willReturn([$user]);

        $userGetCollectionDto = new GetUsersCollectionDto(10, 0);

        $getUserService = new GetUsersCollectionService($userRepository);
        $response = $getUserService->execute($userGetCollectionDto);

        $this->assertInstanceOf(GetUsersCollectionResponse::class, $response);
    }

    public function testExecuteEmptyResults(): void
    {
        $userRepository = $this->createMock(UserRepository::class);
        $userRepository->expects($this->once())
            ->method('findUsersNotDeleted')
            ->willReturn([]);

        $userGetCollectionDto = new GetUsersCollectionDto(10, 0);

        $getUserService = new GetUsersCollectionService($userRepository);
        $response = $getUserService->execute($userGetCollectionDto);

        $this->assertEmpty($response);
    }
}
