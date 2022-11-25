<?php

declare(strict_types=1);

namespace App\Tests\Unit\Dto\Util;

use App\Dto\Util\Paginator;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Webmozart\Assert\InvalidArgumentException;

class PaginatorTest extends TestCase
{
    public function testGetOffset(): void
    {
        $request = new Request(['offset' => 0]);
        $paginator = new Paginator();

        $offset = $paginator->getOffset($request);

        $this->assertEquals(0, $offset);
    }

    public function testGetLimit(): void
    {
        $request = new Request(['limit' => 10]);
        $paginator = new Paginator();

        $limit = $paginator->getLimit($request);

        $this->assertEquals(10, $limit);
    }

    public function testGetLimitRangeFail(): void
    {
        $request = new Request(['limit' => 1000]);
        $paginator = new Paginator();

        $this->expectException(InvalidArgumentException::class);
        $paginator->getLimit($request);
    }
}
