<?php

declare(strict_types=1);

namespace App\Controller\v1\User;

use App\Dto\User\UpdateUserDto;
use App\Service\User\UpdateUserService;
use OpenApi\Attributes as OAT;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/v1/users/{id}', name: 'update_user', methods: ['PUT'])]
#[OAT\Tag(name: 'users')]
#[OAT\Parameter(ref: '#/components/parameters/id')]
#[OAT\RequestBody(content: new OAT\JsonContent(ref: '#/components/schemas/UpdateUserDto'))]
#[OAT\Response(
    response: Response::HTTP_CREATED,
    description: 'Updated user',
    content: new OAT\JsonContent(ref: '#/components/schemas/GetUserResponse'),
)]
#[OAT\Response(ref: '#/components/responses/400BadRequest', response: Response::HTTP_BAD_REQUEST)]
class UpdateUserController
{
    public function __invoke(Request $request, UpdateUserService $updateUserService, int $id): JsonResponse
    {
        $updateUserDto = UpdateUserDto::createFromRequest($request);

        $response = $updateUserService->execute($id, $updateUserDto);

        return new JsonResponse($response->jsonSerialize(), Response::HTTP_CREATED);
    }
}
