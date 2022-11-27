<?php
declare(strict_types=1);


namespace App\Tests\Funtional\Controller\v1\WorkEntry;

use App\Response\User\GetUserResponse;
use App\Response\WorkEntry\GetWorkEntryResponse;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class DeleteWorkEntryControllerTest extends WebTestCase
{

    public function testDeleteWorkEntry(): void
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
            'DELETE',
            '/api/v1/workentries/'.$workEntry->id
        );

        $this->assertEquals(Response::HTTP_NO_CONTENT, $client->getResponse()->getStatusCode());
    }

    public function testDeleteWorkEntryFailed(): void
    {
        $client = static::createClient();
        $client->request('DELETE', '/api/v1/workentries/1');
        $this->assertEquals(Response::HTTP_NOT_FOUND, $client->getResponse()->getStatusCode());
    }
}
