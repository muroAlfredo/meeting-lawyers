<?php

declare(strict_types=1);

namespace App\Controller\v1\WorkEntry;

use App\Service\WorkEntry\DeleteWorkEntryService;
use OpenApi\Attributes as OAT;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/v1/workentries/{id}', name: 'delete_work_entry', methods: ['DELETE'])]
#[OAT\Tag(name: 'work entries')]
#[OAT\Parameter(ref: '#/components/parameters/id')]
#[OAT\Response(
    response: Response::HTTP_NO_CONTENT,
    description: 'Deleted work entry'
)]
#[OAT\Response(ref: '#/components/responses/404WorkEntryNotFound', response: Response::HTTP_NOT_FOUND)]
class DeleteWorkEntryController
{
    public function __invoke(DeleteWorkEntryService $deleteWorkEntryService, int $id): JsonResponse
    {
        $deleteWorkEntryService->execute($id);

        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }
}
