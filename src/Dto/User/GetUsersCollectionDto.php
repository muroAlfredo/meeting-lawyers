<?php

declare(strict_types=1);

namespace App\Dto\User;

use App\Constant\PaginatorConstant;
use App\Dto\Util\Paginator;
use OpenApi\Attributes as OAT;
use Symfony\Component\HttpFoundation\Request;

class GetUsersCollectionDto
{
    public function __construct(
        #[OAT\Property(property: 'limit', example: '50')]
        public readonly int $limit = PaginatorConstant::DEFAULT_LIMIT,
        #[OAT\Property(property: 'offset', example: '0')]
        public readonly int $offset = PaginatorConstant::DEFAULT_OFFSET
    ) {
    }

    public static function createFromRequest(Request $request): self
    {
        $paginator = new Paginator();

        $limit = $paginator->getLimit($request);
        $offset = $paginator->getOffset($request);

        return new self(
            $limit,
            $offset
        );
    }
}
