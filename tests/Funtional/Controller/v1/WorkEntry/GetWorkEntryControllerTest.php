<?php
declare(strict_types=1);


namespace App\Tests\Funtional\Controller\v1\WorkEntry;

use App\Response\User\GetUserResponse;
use App\Response\WorkEntry\GetWorkEntryResponse;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class GetWorkEntryControllerTest extends WebTestCase
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

        $response = $client->getResponse();
        /** @var string $responseContent */
        $responseContent = $response->getContent();
        /** @var GetWorkEntryResponse $workEntry */
        $workEntry = json_decode($responseContent);

        $client->request(
            'GET',
            '/api/v1/workentries/'.$workEntry->id
        );

        $this->assertEquals(Response::HTTP_OK, $client->getResponse()->getStatusCode());
    }

    public function testGetWorkEntryFailed(): void
    {
        $client = static::createClient();
        $client->request('GET', '/api/v1/workentries/1');
        $this->assertEquals(Response::HTTP_NOT_FOUND, $client->getResponse()->getStatusCode());
    }
}
