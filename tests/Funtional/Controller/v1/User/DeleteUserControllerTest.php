<?php
declare(strict_types=1);


namespace App\Tests\Funtional\Controller\v1\User;

use App\Response\User\GetUserResponse;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class DeleteUserControllerTest extends WebTestCase
{

    public function testDeleteUser(): void
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
            'DELETE',
            '/api/v1/users/'.$user->id
        );

        $this->assertEquals(Response::HTTP_NO_CONTENT, $client->getResponse()->getStatusCode());
    }

    public function testDeleteUserFailed(): void
    {
        $client = static::createClient();
        $client->request('DELETE', '/api/v1/users/1');
        $this->assertEquals(Response::HTTP_NOT_FOUND, $client->getResponse()->getStatusCode());
    }
}
