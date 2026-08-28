<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Streaming;

final readonly class StreamFrame
{
    public function __construct(
        public StreamType $type,
        public string $payload,
    ) {}
}
