<?php

declare(strict_types=1);

namespace App\Controller\v1\WorkEntry;

use App\Dto\WorkEntry\CreateWorkEntryDto;
use App\Service\WorkEntry\CreateWorkEntryService;
use OpenApi\Attributes as OAT;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/v1/workentries', name: 'create_work_entry', methods: ['POST'])]
#[OAT\Tag(name: 'work entries')]
#[OAT\RequestBody(content: new OAT\JsonContent(ref: '#/components/schemas/CreateWorkEntryDto'))]
#[OAT\Response(
    response: Response::HTTP_CREATED,
    description: 'Created work entry',
    content: new OAT\JsonContent(ref: '#/components/schemas/GetWorkEntryResponse'),
)]
#[OAT\Response(ref: '#/components/responses/400BadRequest', response: Response::HTTP_BAD_REQUEST)]
#[OAT\Response(ref: '#/components/responses/404UserNotFound', response: Response::HTTP_NOT_FOUND)]
class CreateWorkEntryController
{
    public function __invoke(Request $request, CreateWorkEntryService $createWorkEntryService): JsonResponse
    {
        $createWorkEntryDto = CreateWorkEntryDto::createFromRequest($request);

        $response = $createWorkEntryService->execute($createWorkEntryDto);

        return new JsonResponse($response->jsonSerialize(), Response::HTTP_CREATED);
    }
}
