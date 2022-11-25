<?php

declare(strict_types=1);

namespace App\Tests\Integration\Repository;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class UserRepositoryTest extends KernelTestCase
{
    public function testFindUserByIdNotDeleted(): void
    {
        $user = new User();
        $user->setName('foo');
        $user->setEmail('foo@bar.com');

        self::bootKernel();
        /** @var UserRepository $repository */
        $repository = self::getContainer()->get(UserRepository::class);

        $repository->save($user, true);
        /** @var int $id */
        $id = $user->getId();
        $userDB = $repository->findUserByIdNotDeleted($id);

        $this->assertInstanceOf(User::class, $userDB);
    }

    public function testFindUserByIdIsDeleted(): void
    {
        $user = new User();
        $user->setName('foo');
        $user->setEmail('foo@bar.com');
        $user->setDeletedAt(new \DateTimeImmutable());

        self::bootKernel();
        /** @var UserRepository $repository */
        $repository = self::getContainer()->get(UserRepository::class);

        $repository->save($user, true);
        /** @var int $id */
        $id = $user->getId();
        $userDB = $repository->findUserByIdNotDeleted($id);

        $this->assertNull($userDB);
    }
}
