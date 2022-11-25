<?php

declare(strict_types=1);

namespace App\Entity\SoftDeletable;

use Doctrine\ORM\Mapping as ORM;

trait SoftDeletableTrait
{
    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $deletedAt = null;

    public function setDeletedAt(?\DateTimeImmutable $deletedAt = null): void
    {
        $this->deletedAt = $deletedAt;
    }
}
