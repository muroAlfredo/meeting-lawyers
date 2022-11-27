<?php

declare(strict_types=1);

namespace App\Response\WorkEntry;

use App\Response\User\GetUserResponse;
use OpenApi\Attributes as OAT;

class GetWorkEntryResponse implements \JsonSerializable
{
    /**
     * @param int|null                    $id
     * @param array<int, GetUserResponse> $user
     * @param \DateTimeImmutable          $createdAt
     * @param \DateTimeImmutable          $updatedAt
     * @param \DateTimeInterface          $startDate
     * @param \DateTimeInterface|null     $endDate
     */
    public function __construct(
        #[OAT\Property(example: 5)]
        public readonly ?int $id,
        #[OAT\Property(type: 'array', items: new OAT\Items(ref: '#/components/schemas/GetUserResponse'))]
        public readonly array $user,
        #[OAT\Property(example: '2022-01-01 00:00:00')]
        public readonly \DateTimeImmutable $createdAt,
        #[OAT\Property(example: '2022-01-01 00:00:00')]
        public readonly \DateTimeImmutable $updatedAt,
        #[OAT\Property(example: '2022-01-01 00:00:00')]
        public readonly \DateTimeInterface $startDate,
        #[OAT\Property(example: '2022-01-01 00:00:00')]
        public readonly ?\DateTimeInterface $endDate = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'user' => $this->user,
            'startDate' => $this->startDate->format('Y-m-d H:i:s'),
            'endDate' => $this->endDate?->format('Y-m-d H:i'),
            'createdAt' => $this->createdAt->format('Y-m-d H:i:s'),
            'updatedAt' => $this->updatedAt->format('Y-m-d H:i:s'),
        ];
    }
}
