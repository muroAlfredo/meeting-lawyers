<?php

declare(strict_types=1);

namespace App\Entity\Timestampable;

interface TimestampableInterface
{
    public function getCreatedAt(): \DateTimeImmutable;

    public function setCreatedAt(\DateTimeImmutable $createdAt): void;

    public function getUpdatedAt(): \DateTimeImmutable;

    public function setUpdatedAt(\DateTimeImmutable $updatedAt): void;
}
