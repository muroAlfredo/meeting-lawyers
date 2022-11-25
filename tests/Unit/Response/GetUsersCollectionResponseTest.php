<?php

declare(strict_types=1);

namespace App\Tests\Unit\Response;

use App\Response\User\GetUserResponse;
use App\Response\User\GetUsersCollectionResponse;
use PHPUnit\Framework\TestCase;

class GetUsersCollectionResponseTest extends TestCase
{
    public function testGet(): void
    {
        $getUserResponse = new GetUserResponse(
            1,
            'name',
            'emain@fake.com',
            new \DateTimeImmutable(),
            new \DateTimeImmutable()
        );

        $getUsersCollectionResponse = new GetUsersCollectionResponse(
            10,
            0,
            [0 => $getUserResponse],
            1
        );

        $response = $getUsersCollectionResponse->jsonSerialize();

        $this->assertEquals($response['limit'], $getUsersCollectionResponse->limit);
        $this->assertEquals($response['offset'], $getUsersCollectionResponse->offset);
        $this->assertEquals($response['total'], $getUsersCollectionResponse->total);
        $this->assertEquals($response['results'], $getUsersCollectionResponse->results);
    }
}
