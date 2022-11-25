<?php

declare(strict_types=1);

namespace App\Response\User;

use OpenApi\Attributes as OAT;

class GetUserResponse implements \JsonSerializable
{
    public function __construct(
        #[OAT\Property(example: 5)]
        public readonly ?int $id,
        #[OAT\Property(example: 'John Smith')]
        public readonly string $name,
        #[OAT\Property(example: 'email@example.com')]
        public readonly string $email,
        #[OAT\Property(example: '2022-01-01 00:00:00')]
        public readonly \DateTimeImmutable $createdAt,
        #[OAT\Property(example: '2022-01-01 00:00:00')]
        public readonly \DateTimeImmutable $updatedAt,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'createdAt' => $this->createdAt->format('Y-m-d H:i:s'),
            'updatedAt' => $this->updatedAt->format('Y-m-d H:i:s'),
        ];
    }
}
