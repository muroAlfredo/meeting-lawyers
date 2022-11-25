<?php

declare(strict_types=1);

namespace App\Tests\Unit\Dto\User;

use App\Dto\User\UpdateUserDto;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Webmozart\Assert\InvalidArgumentException;

class UpdateUserDtoTest extends TestCase
{
    public function testUpdateFromRequest(): void
    {
        $payload = [
            'name' => 'name username',
            'email' => 'email@example.com',
        ];

        $request = $this->createMock(Request::class);
        $request->expects($this->exactly(1))
            ->method('getContent')
            ->willReturn(json_encode($payload));

        $dto = UpdateUserDto::createFromRequest($request);

        $this->assertEquals($payload['name'], $dto->name);
        $this->assertEquals($payload['email'], $dto->email);
    }

    public function testUpdateFromRequestWithoutEmail(): void
    {
        $payload = [
            'name' => 'name username',
        ];

        $request = $this->createMock(Request::class);
        $request->expects($this->exactly(1))
            ->method('getContent')
            ->willReturn(json_encode($payload));

        $this->expectException(InvalidArgumentException::class);

        UpdateUserDto::createFromRequest($request);
    }

    public function testUpdateFromRequestWithoutName(): void
    {
        $payload = [
            'email' => 'email@example.com',
        ];

        $request = $this->createMock(Request::class);
        $request->expects($this->exactly(1))
            ->method('getContent')
            ->willReturn(json_encode($payload));

        $this->expectException(InvalidArgumentException::class);

        UpdateUserDto::createFromRequest($request);
    }

    public function testUpdateFromRequestErrorFormatEmail(): void
    {
        $payload = [
            'name' => 'name username',
            'email' => 'email',
        ];

        $request = $this->createMock(Request::class);
        $request->expects($this->exactly(1))
            ->method('getContent')
            ->willReturn(json_encode($payload));

        $this->expectException(InvalidArgumentException::class);
        $this->expectErrorMessageMatches('/Expected a value to be a valid e-mail address/');

        UpdateUserDto::createFromRequest($request);
    }
}
