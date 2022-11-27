<?php
declare(strict_types=1);


namespace App\Tests\Funtional\Controller\v1\WorkEntry;

use App\Response\User\GetUserResponse;
use App\Response\WorkEntry\GetWorkEntryResponse;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class UpdateWorkEntryControllerTest extends WebTestCase
{

    public function testUpdateWorkEntry(): void
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
            'PUT',
            '/api/v1/workentries/'.$workEntry->id,
            [],
            [],
            [],
            $content
        );

        $this->assertEquals(Response::HTTP_CREATED, $client->getResponse()->getStatusCode());
    }
}
