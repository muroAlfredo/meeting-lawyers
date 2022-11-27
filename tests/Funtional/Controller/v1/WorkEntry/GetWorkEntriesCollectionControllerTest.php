<?php
declare(strict_types=1);


namespace App\Tests\Funtional\Controller\v1\WorkEntry;

use App\Response\User\GetUserResponse;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class GetWorkEntriesCollectionControllerTest extends WebTestCase
{

    public function testGetWorkEntry(): void
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

        $client->request(
            'GET',
            '/api/v1/workentries'
        );

        $this->assertEquals(Response::HTTP_OK, $client->getResponse()->getStatusCode());
    }
}
