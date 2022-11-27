<?php

declare(strict_types=1);

namespace App\Controller\v1\WorkEntry;

use App\Service\WorkEntry\GetWorkEntryService;
use OpenApi\Attributes as OAT;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/v1/workentries/{id}', name: 'get_work_entry', methods: ['GET'])]
#[OAT\Tag(name: 'work entries')]
#[OAT\Parameter(ref: '#/components/parameters/id')]
#[OAT\Response(
    response: Response::HTTP_OK,
    description: 'Get work entry',
    content: new OAT\JsonContent(ref: '#/components/schemas/GetWorkEntryResponse'),
)]
#[OAT\Response(ref: '#/components/responses/404WorkEntryNotFound', response: Response::HTTP_NOT_FOUND)]
class GetWorkEntryController
{
    public function __invoke(GetWorkEntryService $getWorkEntryService, int $id): JsonResponse
    {
        $response = $getWorkEntryService->execute($id);

        return new JsonResponse($response->jsonSerialize(), Response::HTTP_OK);
    }
}
