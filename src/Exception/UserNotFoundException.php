<?php

declare(strict_types=1);

namespace App\Exception;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class UserNotFoundException extends NotFoundHttpException
{
    private const MESSAGE = 'User with id %d not found';

    /**
     * @param array<string, mixed> $headers
     */
    public function __construct(int $id, \Throwable $previous = null, int $code = 404, array $headers = [])
    {
        parent::__construct(sprintf(self::MESSAGE, $id), $previous, $code, $headers);
    }
}
