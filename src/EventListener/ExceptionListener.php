<?php

declare(strict_types=1);

namespace App\EventListener;

use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Webmozart\Assert\InvalidArgumentException;

class ExceptionListener
{
    public function __construct(
        private LoggerInterface $logger
    ) {
    }

    public function onKernelException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();

        if ($exception instanceof HttpExceptionInterface || $exception instanceof InvalidArgumentException) {
            $code = $exception->getCode();
            $message = $exception->getMessage();

            $data = [
                'class' => get_class($exception),
                'code' => empty($code) ? 400 : $code,
                'message' => $message,
            ];

            $this->logger->error($message, ['code' => $code]);

            $event->setResponse($this->prepareResponse($data, $data['code']));
        }
    }

    /**
     * @param array<string, mixed> $data
     */
    private function prepareResponse(array $data, int $statusCode): JsonResponse
    {
        return new JsonResponse($data, $statusCode);
    }
}
