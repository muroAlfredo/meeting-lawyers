<?php

declare(strict_types=1);

namespace App\Exception;

use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class EndDateLessThanStartDateException extends BadRequestHttpException
{
    private const MESSAGE = 'The end date must be greater than the start date';

    /**
     * @param array<string, mixed> $headers
     */
    public function __construct(\Throwable $previous = null, int $code = 400, array $headers = [])
    {
        parent::__construct(self::MESSAGE, $previous, $code, $headers);
    }
}
