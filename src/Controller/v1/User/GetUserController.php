<?php

declare(strict_types=1);

namespace App\Controller\v1\User;

use App\Service\User\GetUserService;
use OpenApi\Attributes as OAT;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/v1/users/{id}', name: 'get_user', methods: ['GET'])]
#[OAT\Tag(name: 'users')]
#[OAT\Parameter(ref: '#/components/parameters/id')]
#[OAT\Response(
    response: Response::HTTP_OK,
    description: 'Get user',
    content: new OAT\JsonContent(ref: '#/components/schemas/GetUserResponse'),
)]
#[OAT\Response(ref: '#/components/responses/404UserNotFound', response: Response::HTTP_NOT_FOUND)]
class GetUserController
{
    public function __invoke(GetUserService $getUserService, int $id): JsonResponse
    {
        $response = $getUserService->execute($id);

        return new JsonResponse($response->jsonSerialize(), Response::HTTP_OK);
    }
}
