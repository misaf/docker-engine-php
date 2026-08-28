<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Exceptions;

class ApiException extends DockerException
{
    /** @param array<string, list<string>> $headers */
    public function __construct(
        string $message,
        public readonly int $statusCode,
        public readonly array $headers = [],
        public readonly string $responseBody = '',
    ) {
        parent::__construct($message, $statusCode);
    }
}
