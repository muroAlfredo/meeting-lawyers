<?php

declare(strict_types=1);

namespace App\Tests\Unit\Service\User;

use App\Dto\User\CreateUserDto;
use App\Entity\User;
use App\Repository\UserRepository;
use App\Service\User\CreateUserService;
use PHPUnit\Framework\TestCase;

class CreateUserServiceTest extends TestCase
{
    public function testExecute(): void
    {
        $userRepository = $this->createMock(UserRepository::class);
        $name = 'name username';
        $email = 'email@email.com';
        $createUserDto = new CreateUserDto($name, $email);
        /** @var User $userObject */
        $userObject = null;
        $userRepository->expects($this->once())
            ->method('save')
            ->willReturnCallback(
                function (User $user) use (&$userObject) {
                    $user->setCreatedAt(new \DateTimeImmutable());
                    $user->setUpdatedAt(new \DateTimeImmutable());
                    $userObject = $user;
                }
            );

        $userService = new CreateUserService($userRepository);
        $response = $userService->execute($createUserDto);

        $this->assertEquals($userObject->getName(), $response->name);
        $this->assertEquals($userObject->getEmail(), $response->email);
    }
}
