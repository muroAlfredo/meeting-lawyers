<?php
declare(strict_types=1);


namespace App\Tests\Funtional\Controller\v1\User;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class GetUsersCollectionControllerTest extends WebTestCase
{

    public function testGetUsers(): void
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

        $client->request(
            'GET',
            '/api/v1/users'
        );

        $this->assertEquals(Response::HTTP_OK, $client->getResponse()->getStatusCode());
    }
}
