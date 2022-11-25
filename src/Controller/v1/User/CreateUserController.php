<?php

declare(strict_types=1);

namespace App\Controller\v1\User;

use App\Dto\User\CreateUserDto;
use App\Service\User\CreateUserService;
use OpenApi\Attributes as OAT;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/v1/users', name: 'create_user', methods: ['POST'])]
#[OAT\Tag(name: 'users')]
#[OAT\RequestBody(content: new OAT\JsonContent(ref: '#/components/schemas/CreateUserDto'))]
#[OAT\Response(
    response: Response::HTTP_CREATED,
    description: 'Created user',
    content: new OAT\JsonContent(ref: '#/components/schemas/GetUserResponse'),
)]
#[OAT\Response(ref: '#/components/responses/400BadRequest', response: Response::HTTP_BAD_REQUEST)]
class CreateUserController
{
    public function __invoke(Request $request, CreateUserService $createUserService): JsonResponse
    {
        $createUserDto = CreateUserDto::createFromRequest($request);

        $response = $createUserService->execute($createUserDto);

        return new JsonResponse($response->jsonSerialize(), Response::HTTP_CREATED);
    }
}
