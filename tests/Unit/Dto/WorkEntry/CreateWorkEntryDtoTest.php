<?php
declare(strict_types=1);


namespace App\Tests\Unit\Dto\WorkEntry;

use App\Dto\WorkEntry\CreateWorkEntryDto;
use App\Exception\EndDateLessThanStartDateException;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Webmozart\Assert\InvalidArgumentException;

class CreateWorkEntryDtoTest extends TestCase
{
    public function testCreateFromRequest(): void
    {
        $payload = [
            'userId' => 1,
            'startDate' => '2022-01-01 00:00:00'
        ];
        $request = $this->createMock(Request::class);
        $request->expects($this->exactly(1))
            ->method('getContent')
            ->willReturn(json_encode($payload));

        $dto = CreateWorkEntryDto::createFromRequest($request);

        $this->assertEquals($payload['userId'], $dto->userId);
        $this->assertEquals(new \DateTime($payload['startDate']), $dto->startDate);
    }

    public function testCreateFromRequestWithoutUserId(): void
    {
        $payload = [
            'startDate' => '2022-01-01 00:00:00'
        ];
        $request = $this->createMock(Request::class);
        $request->expects($this->exactly(1))
            ->method('getContent')
            ->willReturn(json_encode($payload));

        $this->expectException(InvalidArgumentException::class);

        CreateWorkEntryDto::createFromRequest($request);
    }

    public function testCreateFromRequestWithoutStartDate(): void
    {
        $payload = [
            'userId' => 1,
        ];
        $request = $this->createMock(Request::class);
        $request->expects($this->exactly(1))
            ->method('getContent')
            ->willReturn(json_encode($payload));

        $this->expectException(InvalidArgumentException::class);

        CreateWorkEntryDto::createFromRequest($request);
    }

    public function testCreateFromRequestWithUserIdZero(): void
    {
        $payload = [
            'userId' => 0,
        ];
        $request = $this->createMock(Request::class);
        $request->expects($this->exactly(1))
            ->method('getContent')
            ->willReturn(json_encode($payload));

        $this->expectException(InvalidArgumentException::class);

        CreateWorkEntryDto::createFromRequest($request);
    }

    public function testCreateFromRequestFormatStartDateIncorrect(): void
    {
        $payload = [
            'userId' => 1,
            'startDate' => '2022-01-01 00'
        ];
        $request = $this->createMock(Request::class);
        $request->expects($this->exactly(1))
            ->method('getContent')
            ->willReturn(json_encode($payload));

        $this->expectException(InvalidArgumentException::class);

        CreateWorkEntryDto::createFromRequest($request);
    }

    public function testCreateFromRequestFormatEndDateIncorrect(): void
    {
        $payload = [
            'userId' => 1,
            'startDate' => '2022-01-01 00:00:00',
            'endDate' => '2022-01-01 00'
        ];
        $request = $this->createMock(Request::class);
        $request->expects($this->exactly(1))
            ->method('getContent')
            ->willReturn(json_encode($payload));

        $this->expectException(InvalidArgumentException::class);

        CreateWorkEntryDto::createFromRequest($request);
    }

    public function testCreateFromRequestFormatEndDateLessThanStartDate(): void
    {
        $payload = [
            'userId' => 1,
            'startDate' => '2022-01-01 12:00:00',
            'endDate' => '2022-01-01 00:00:00'
        ];
        $request = $this->createMock(Request::class);
        $request->expects($this->exactly(1))
            ->method('getContent')
            ->willReturn(json_encode($payload));

        $this->expectException(EndDateLessThanStartDateException::class);

        CreateWorkEntryDto::createFromRequest($request);
    }
}