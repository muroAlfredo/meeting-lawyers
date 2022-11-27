<?php

declare(strict_types=1);

namespace App\Tests\Unit\Dto\WorkEntry;

use App\Dto\WorkEntry\GetWorkEntriesCollectionDto;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Webmozart\Assert\InvalidArgumentException;

class GetWorkEntriesCollectionDtoTest extends TestCase
{
    public function testCreateFromRequest(): void
    {
        $query = [
            'limit' => 10,
            'offset' => 0,
        ];

        $request = new Request($query);

        $dto = GetWorkEntriesCollectionDto::createFromRequest($request);

        $this->assertEquals($query['limit'], $dto->limit);
        $this->assertEquals($query['offset'], $dto->offset);
    }

    public function testCreateFromRequestLimitFail(): void
    {
        $query = [
            'limit' => 1000,
            'offset' => 0,
        ];

        $request = new Request($query);

        $this->expectException(InvalidArgumentException::class);

        GetWorkEntriesCollectionDto::createFromRequest($request);
    }
}
