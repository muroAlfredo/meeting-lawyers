<?php

declare(strict_types=1);

namespace App\Controller\v1\User;

use App\Dto\User\GetUsersCollectionDto;
use App\Response\User\GetUsersCollectionResponse;
use App\Service\User\GetUsersCollectionService;
use OpenApi\Attributes as OAT;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/v1/users', name: 'get_users_collection', methods: ['GET'])]
#[OAT\Tag(name: 'users')]
#[OAT\Parameter(ref: '#/components/parameters/limit')]
#[OAT\Parameter(ref: '#/components/parameters/offset')]
#[OAT\Response(
    response: Response::HTTP_OK,
    description: 'Get users collection',
    content: new OAT\JsonContent(ref: '#/components/schemas/GetUsersCollectionResponse'),
)]
#[OAT\Response(ref: '#/components/responses/400BadRequest', response: Response::HTTP_BAD_REQUEST)]
class GetUsersCollectionController
{
    public function __invoke(Request $request, GetUsersCollectionService $getUsersCollectionService): JsonResponse
    {
        $getUsersCollectionDto = GetUsersCollectionDto::createFromRequest($request);

        $response = $getUsersCollectionService->execute($getUsersCollectionDto);

        return new JsonResponse(
            $response instanceof GetUsersCollectionResponse ? $response->jsonSerialize() : $response,
            Response::HTTP_OK
        );
    }
}
