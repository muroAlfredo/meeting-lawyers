<?php

declare(strict_types=1);

namespace App\Controller\v1\WorkEntry;

use App\Dto\WorkEntry\GetWorkEntriesCollectionDto;
use App\Response\WorkEntry\GetWorkEntriesCollectionResponse;
use App\Service\WorkEntry\GetWorkEntriesCollectionService;
use OpenApi\Attributes as OAT;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/v1/workentries', name: 'get_work_entries_collection', methods: ['GET'])]
#[OAT\Tag(name: 'work entries')]
#[OAT\Parameter(ref: '#/components/parameters/limit')]
#[OAT\Parameter(ref: '#/components/parameters/offset')]
#[OAT\Response(
    response: Response::HTTP_OK,
    description: 'Get work entries collection',
    content: new OAT\JsonContent(ref: '#/components/schemas/GetWorkEntriesCollectionResponse'),
)]
#[OAT\Response(ref: '#/components/responses/400BadRequest', response: Response::HTTP_BAD_REQUEST)]
class GetWorkEntriesCollectionController
{
    public function __invoke(Request $request, GetWorkEntriesCollectionService $getWorkEntriesCollectionService): JsonResponse
    {
        $getWorkEntriesCollectionDto = GetWorkEntriesCollectionDto::createFromRequest($request);

        $response = $getWorkEntriesCollectionService->execute($getWorkEntriesCollectionDto);

        return new JsonResponse(
            $response instanceof GetWorkEntriesCollectionResponse ? $response->jsonSerialize() : $response,
            Response::HTTP_OK
        );
    }
}
