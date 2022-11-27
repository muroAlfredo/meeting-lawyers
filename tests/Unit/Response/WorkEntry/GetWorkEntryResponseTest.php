<?php

declare(strict_types=1);

namespace App\Tests\Unit\Response\WorkEntry;

use App\Response\User\GetUserResponse;
use App\Response\WorkEntry\GetWorkEntryResponse;
use PHPUnit\Framework\TestCase;

class GetWorkEntryResponseTest extends TestCase
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

        $getUserResponse = new GetWorkEntryResponse(
            1,
            [$user],
            new \DateTimeImmutable(),
            new \DateTimeImmutable(),
            new \DateTime('now'),
            null,
        );

        $response = $getUserResponse->jsonSerialize();

        $this->assertEquals($response['id'], $getUserResponse->id);
        $this->assertEquals($response['user'], $getUserResponse->user);
        $this->assertEquals($response['startDate'], $getUserResponse->startDate->format('Y-m-d H:i:s'));
        $this->assertEquals(null, $response['endDate']);
        $this->assertEquals($response['createdAt'], $getUserResponse->createdAt->format('Y-m-d H:i:s'));
        $this->assertEquals($response['updatedAt'], $getUserResponse->updatedAt->format('Y-m-d H:i:s'));
    }
}
