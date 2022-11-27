<?php

declare(strict_types=1);

namespace App\Tests\Unit\Response\User;

use App\Response\User\GetUserResponse;
use PHPUnit\Framework\TestCase;

class GetUserResponseTest extends TestCase
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

        $response = $getUserResponse->jsonSerialize();

        $this->assertEquals($response['id'], $getUserResponse->id);
        $this->assertEquals($response['name'], $getUserResponse->name);
        $this->assertEquals($response['email'], $getUserResponse->email);
        $this->assertEquals($response['createdAt'], $getUserResponse->createdAt->format('Y-m-d H:i:s'));
        $this->assertEquals($response['updatedAt'], $getUserResponse->updatedAt->format('Y-m-d H:i:s'));
    }
}
