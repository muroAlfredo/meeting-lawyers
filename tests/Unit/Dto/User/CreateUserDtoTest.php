<?php

declare(strict_types=1);

namespace App\Tests\Unit\Dto\User;

use App\Dto\User\CreateUserDto;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Webmozart\Assert\InvalidArgumentException;

class CreateUserDtoTest extends TestCase
{
    public function testCreateFromRequest(): void
    {
        $payload = [
            'name' => 'name username',
            'email' => 'email@example.com',
        ];

        $request = $this->createMock(Request::class);
        $request->expects($this->exactly(1))
            ->method('getContent')
            ->willReturn(json_encode($payload));

        $dto = CreateUserDto::createFromRequest($request);

        $this->assertEquals($payload['name'], $dto->name);
        $this->assertEquals($payload['email'], $dto->email);
    }

    public function testCreateFromRequestWithoutEmail(): void
    {
        $payload = [
            'name' => 'name username',
        ];

        $request = $this->createMock(Request::class);
        $request->expects($this->exactly(1))
            ->method('getContent')
            ->willReturn(json_encode($payload));

        $this->expectException(InvalidArgumentException::class);

        CreateUserDto::createFromRequest($request);
    }

    public function testCreateFromRequestWithoutName(): void
    {
        $payload = [
            'email' => 'email@example.com',
        ];

        $request = $this->createMock(Request::class);
        $request->expects($this->exactly(1))
            ->method('getContent')
            ->willReturn(json_encode($payload));

        $this->expectException(InvalidArgumentException::class);

        CreateUserDto::createFromRequest($request);
    }

    public function testCreateFromRequestErrorFormatEmail(): void
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

        CreateUserDto::createFromRequest($request);
    }
}
