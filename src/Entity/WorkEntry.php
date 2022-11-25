<?php

namespace App\Entity;

use App\Entity\SoftDeletable\SoftDeletableInterface;
use App\Entity\SoftDeletable\SoftDeletableTrait;
use App\Entity\Timestampable\TimestampableInterface;
use App\Entity\Timestampable\TimestampableTrait;
use App\Repository\WorkEntryRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: WorkEntryRepository::class)]
#[ORM\HasLifecycleCallbacks]
class WorkEntry implements TimestampableInterface, SoftDeletableInterface
{
    use SoftDeletableTrait;
    use TimestampableTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private int $id;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(name: 'user_id', nullable: false)]
    private User $userId;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private \DateTimeInterface $startDate;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $endDate;

    public function getId(): int
    {
        return $this->id;
    }

    public function getUserId(): User
    {
        return $this->userId;
    }

    public function setUserId(User $userId): self
    {
        $this->userId = $userId;

        return $this;
    }

    public function getStartDate(): \DateTimeInterface
    {
        return $this->startDate;
    }

    public function setStartDate(\DateTimeInterface $startDate): self
    {
        $this->startDate = $startDate;

        return $this;
    }

    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->endDate;
    }

    public function setEndDate(?\DateTimeInterface $endDate): self
    {
        $this->endDate = $endDate;

        return $this;
    }
}
