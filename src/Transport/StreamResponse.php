<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Transport;

use Misaf\DockerEngine\Contracts\Stream;

final readonly class StreamResponse
{
    /** @param array<string, list<string>> $headers */
    public function __construct(
        public int $statusCode,
        public array $headers,
        public Stream $stream,
    ) {}
}
