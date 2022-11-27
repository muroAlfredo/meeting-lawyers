<?php
declare(strict_types=1);


namespace App\Tests\Funtional\Controller\v1\WorkEntry;

use App\Response\User\GetUserResponse;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class CreateWorkEntryControllerTest extends WebTestCase
{

    public function testCreateWorkEntry(): void
    {
        $client = static::createClient();

        /** @var string $contentUser */
        $contentUser = json_encode([
            "name" => "name username",
            "email" => "email@example.com"
        ]);

        $client->request(
            'POST',
            '/api/v1/users',
            [],
            [],
            [],
            $contentUser
        );

        $response = $client->getResponse();
        /** @var string $responseContent */
        $responseContent = $response->getContent();
        /** @var GetUserResponse $user */
        $user = json_decode($responseContent);

        /** @var string $content */
        $content = json_encode([
            "userId" => $user->id,
            "startDate" => "2022-01-01 00:00:00",
        ]);

        $client->request(
            'POST',
            '/api/v1/workentries',
            [],
            [],
            [],
            $content
        );

        $this->assertEquals(Response::HTTP_CREATED, $client->getResponse()->getStatusCode());
    }

    public function testCreateWorkEntryFailed(): void
    {
        $client = static::createClient();
        $client->request('POST', '/api/v1/workentries');
        $this->assertEquals(Response::HTTP_BAD_REQUEST, $client->getResponse()->getStatusCode());
    }
}
