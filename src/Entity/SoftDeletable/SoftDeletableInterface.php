<?php

declare(strict_types=1);

namespace App\Entity\SoftDeletable;

interface SoftDeletableInterface
{
    public function setDeletedAt(?\DateTimeImmutable $deletedAt = null): void;
}
