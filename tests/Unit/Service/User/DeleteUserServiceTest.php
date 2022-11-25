<?php

declare(strict_types=1);

namespace App\Tests\Unit\Service\User;

use App\Entity\User;
use App\Exception\UserNotFoundException;
use App\Repository\UserRepository;
use App\Service\User\DeleteUserService;
use PHPUnit\Framework\TestCase;

class DeleteUserServiceTest extends TestCase
{
    public function testExecute(): void
    {
        $userRepository = $this->createMock(UserRepository::class);

        $userRepository->expects($this->once())
            ->method('findUserByIdNotDeleted')
            ->willReturn(new User());

        $deleteUserService = new DeleteUserService($userRepository);
        $deleteUserService->execute(1);

        $this->assertTrue(true);
    }

    public function testExecuteNotFound(): void
    {
        $userRepository = $this->createMock(UserRepository::class);

        $userRepository->expects($this->once())
            ->method('findUserByIdNotDeleted')
            ->willReturn(null);

        $deleteUserService = new DeleteUserService($userRepository);

        $this->expectException(UserNotFoundException::class);
        $deleteUserService->execute(1);
    }
}
