<?php

declare(strict_types=1);

namespace App\Tests\Unit\Service\User;

use App\Entity\User;
use App\Exception\UserNotFoundException;
use App\Repository\UserRepository;
use App\Response\User\GetUserResponse;
use App\Service\User\DeleteUserService;
use App\Service\User\GetUserService;
use PHPUnit\Framework\TestCase;

class GetUserServiceTest extends TestCase
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
            ->method('findUserByIdNotDeleted')
            ->willReturn($user);

        $getUserService = new GetUserService($userRepository);
        $response = $getUserService->execute(1);

        $this->assertInstanceOf(GetUserResponse::class, $response);
    }

    public function testExecuteNotFound(): void
    {
        $userRepository = $this->createMock(UserRepository::class);

        $userRepository->expects($this->once())
            ->method('findUserByIdNotDeleted')
            ->willReturn(null);

        $getUserService = new GetUserService($userRepository);

        $this->expectException(UserNotFoundException::class);
        $getUserService->execute(1);
    }
}
