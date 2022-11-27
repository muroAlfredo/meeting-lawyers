<?php
declare(strict_types=1);


namespace App\Tests\Funtional\Controller\v1\User;

use App\Response\User\GetUserResponse;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class UpdateUserControllerTest extends WebTestCase
{

    public function testGetUser(): void
    {
        $client = static::createClient();
        /** @var string $content */
        $content = json_encode([
            "name" => "name username",
            "email" => "email@example.com"
        ]);

        $client->request(
            'POST',
            '/api/v1/users',
            [],
            [],
            [],
            $content
        );

        $response = $client->getResponse();
        /** @var string $responseContent */
        $responseContent = $response->getContent();
        /** @var GetUserResponse $user */
        $user = json_decode($responseContent);

        $client->request(
            'PUT',
            '/api/v1/users/'.$user->id,
            [],
            [],
            [],
            $content
        );

        $this->assertEquals(Response::HTTP_CREATED, $client->getResponse()->getStatusCode());
    }
}
