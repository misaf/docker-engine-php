<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Exceptions\Api;

use Misaf\DockerEngine\Exceptions\DockerException;

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
