<?php
declare(strict_types=1);


namespace App\Tests\Funtional\Controller\v1\User;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class CreateUserControllerTest extends WebTestCase
{

    public function testCreateUser(): void
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

        $this->assertEquals(Response::HTTP_CREATED, $client->getResponse()->getStatusCode());
    }

    public function testCreateUserFailed(): void
    {
        $client = static::createClient();
        $client->request('POST', '/api/v1/users');
        $this->assertEquals(Response::HTTP_BAD_REQUEST, $client->getResponse()->getStatusCode());
    }
}
