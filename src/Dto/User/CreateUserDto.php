<?php

declare(strict_types=1);

namespace App\Dto\User;

use OpenApi\Attributes as OAT;
use Symfony\Component\HttpFoundation\Request;
use Webmozart\Assert\Assert;

class CreateUserDto
{
    public function __construct(
        #[OAT\Property(property: 'name', example: 'name username')]
        public readonly string $name,
        #[OAT\Property(property: 'email', example: 'email@example.com')]
        public readonly string $email,
    ) {
    }

    public static function createFromRequest(Request $request): self
    {
        $payload = (array) json_decode($request->getContent(), true);

        Assert::keyExists($payload, 'name');
        Assert::keyExists($payload, 'email');

        Assert::stringNotEmpty($payload['name'], 'Name must not be empty');
        Assert::stringNotEmpty($payload['email'], 'Email must not be empty');
        Assert::email($payload['email']);

        return new self(
            $payload['name'],
            $payload['email']
        );
    }
}
