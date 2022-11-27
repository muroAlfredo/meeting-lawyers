<?php

declare(strict_types=1);

namespace App\Tests\Unit\Response\WorkEntry;

use App\Response\User\GetUserResponse;
use App\Response\WorkEntry\GetWorkEntriesCollectionResponse;
use App\Response\WorkEntry\GetWorkEntryResponse;
use PHPUnit\Framework\TestCase;

class GetWorkEntriesCollectionResponseTest extends TestCase
{
    public function testGet(): void
    {
        $user = new GetUserResponse(
            1,
            'name',
            'email@example.com',
            new \DateTimeImmutable(),
            new \DateTimeImmutable()
        );

        $getWorkEntryResponse = new GetWorkEntryResponse(
            1,
            [$user],
            new \DateTimeImmutable(),
            new \DateTimeImmutable(),
            new \DateTime('now'),
            null,
        );

        $getWorkEntriesCollectionResponse = new GetWorkEntriesCollectionResponse(
            10,
            0,
            [0 => $getWorkEntryResponse],
            1
        );

        $response = $getWorkEntriesCollectionResponse->jsonSerialize();

        $this->assertEquals($response['limit'], $getWorkEntriesCollectionResponse->limit);
        $this->assertEquals($response['offset'], $getWorkEntriesCollectionResponse->offset);
        $this->assertEquals($response['total'], $getWorkEntriesCollectionResponse->total);
        $this->assertEquals($response['results'], $getWorkEntriesCollectionResponse->results);
    }
}
