<?php

declare(strict_types=1);

namespace App\Dto\Util;

use App\Constant\PaginatorConstant;
use Symfony\Component\HttpFoundation\Request;
use Webmozart\Assert\Assert;

class Paginator implements PaginatorInterface
{
    public function getLimit(Request $request): int
    {
        $limit = $request->query->getInt('limit', PaginatorConstant::DEFAULT_LIMIT);

        Assert::range($limit, PaginatorConstant::MIN_LIMIT, PaginatorConstant::MAX_LIMIT);

        return $limit;
    }

    public function getOffset(Request $request): int
    {
        return $request->query->getInt('offset', PaginatorConstant::DEFAULT_OFFSET);
    }
}
