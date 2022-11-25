<?php

declare(strict_types=1);

namespace App\Dto\Util;

use Symfony\Component\HttpFoundation\Request;

interface PaginatorInterface
{
    public function getLimit(Request $request): int;

    public function getOffset(Request $request): int;
}
