<?php

declare(strict_types=1);

namespace App\Response\WorkEntry;

use App\Constant\PaginatorConstant;
use OpenApi\Attributes as OAT;

class GetWorkEntriesCollectionResponse implements \JsonSerializable
{
    /**
     * @param int                              $limit
     * @param int                              $offset
     * @param array<int, GetWorkEntryResponse> $results
     * @param int                              $total
     */
    public function __construct(
        #[OAT\Property(example: PaginatorConstant::DEFAULT_LIMIT)]
        public readonly int $limit,
        #[OAT\Property(example: PaginatorConstant::DEFAULT_OFFSET)]
        public readonly int $offset,
        #[OAT\Property(type: 'array', items: new OAT\Items(ref: '#/components/schemas/GetWorkEntryResponse'))]
        public readonly array $results,
        #[OAT\Property(example: 10)]
        public readonly int $total,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'total' => $this->total,
            'offset' => $this->offset,
            'limit' => $this->limit,
            'results' => $this->results,
        ];
    }
}
