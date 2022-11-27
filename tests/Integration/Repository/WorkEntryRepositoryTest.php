<?php

declare(strict_types=1);

namespace App\Tests\Integration\Repository;

use App\Entity\User;
use App\Entity\WorkEntry;
use App\Repository\UserRepository;
use App\Repository\WorkEntryRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class WorkEntryRepositoryTest extends KernelTestCase
{
    public function testFindUserByIdNotDeleted(): void
    {
        self::bootKernel();

        $user = new User();
        $user->setName('foo');
        $user->setEmail('foo@bar.com');

        /** @var UserRepository $userRepository */
        $userRepository = self::getContainer()->get(UserRepository::class);
        $userRepository->save($user, true);

        $workEntry = new WorkEntry();
        $workEntry->setUser($user);
        $workEntry->setStartDate(new \DateTime());


        /** @var WorkEntryRepository $repository */
        $repository = self::getContainer()->get(WorkEntryRepository::class);

        $repository->save($workEntry, true);
        /** @var int $id */
        $id = $workEntry->getId();
        $workEntryDB = $repository->findWorkEntryByIdNotDeleted($id);

        $this->assertInstanceOf(WorkEntry::class, $workEntryDB);
    }

//    public function testFindUserByIdIsDeleted(): void
//    {
//        $user = new User();
//        $user->setName('foo');
//        $user->setEmail('foo@bar.com');
//        $user->setDeletedAt(new \DateTimeImmutable());
//
//        self::bootKernel();
//        /** @var UserRepository $repository */
//        $repository = self::getContainer()->get(UserRepository::class);
//
//        $repository->save($user, true);
//        /** @var int $id */
//        $id = $user->getId();
//        $userDB = $repository->findUserByIdNotDeleted($id);
//
//        $this->assertNull($userDB);
//    }
}
