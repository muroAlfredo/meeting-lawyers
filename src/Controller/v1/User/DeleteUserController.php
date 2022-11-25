<?php

declare(strict_types=1);

namespace App\Controller\v1\User;

use App\Service\User\DeleteUserService;
use OpenApi\Attributes as OAT;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/v1/users/{id}', name: 'delete_user', methods: ['DELETE'])]
#[OAT\Tag(name: 'users')]
#[OAT\Parameter(ref: '#/components/parameters/id')]
#[OAT\Response(
    response: Response::HTTP_NO_CONTENT,
    description: 'Deleted user'
)]
#[OAT\Response(ref: '#/components/responses/404UserNotFound', response: Response::HTTP_NOT_FOUND)]
class DeleteUserController
{
    public function __invoke(DeleteUserService $deleteUserService, int $id): JsonResponse
    {
        $deleteUserService->execute($id);

        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }
}
