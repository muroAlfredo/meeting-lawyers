<?php

declare(strict_types=1);

namespace App\Controller\v1\WorkEntry;

use App\Dto\WorkEntry\UpdateWorkEntryDto;
use App\Service\WorkEntry\UpdateWorkEntryService;
use OpenApi\Attributes as OAT;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/v1/workentries/{id}', name: 'update_work_entry', methods: ['PUT'])]
#[OAT\Tag(name: 'work entries')]
#[OAT\Parameter(ref: '#/components/parameters/id')]
#[OAT\RequestBody(content: new OAT\JsonContent(ref: '#/components/schemas/UpdateWorkEntryDto'))]
#[OAT\Response(
    response: Response::HTTP_CREATED,
    description: 'Updated work entry',
    content: new OAT\JsonContent(ref: '#/components/schemas/GetWorkEntryResponse'),
)]
#[OAT\Response(ref: '#/components/responses/400BadRequest', response: Response::HTTP_BAD_REQUEST)]
class UpdateWorkEntryController
{
    public function __invoke(Request $request, UpdateWorkEntryService $workEntryService, int $id): JsonResponse
    {
        $updateWorkEntryDto = UpdateWorkEntryDto::createFromRequest($request);

        $response = $workEntryService->execute($id, $updateWorkEntryDto);

        return new JsonResponse($response->jsonSerialize(), Response::HTTP_CREATED);
    }
}
