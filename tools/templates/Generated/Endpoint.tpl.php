<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Generated;

final readonly class Endpoint
{
    /** @param class-string<object>|null $responseClass */
    public function __construct(
        public string $operationId,
        public string $method,
        public string $path,
        public ?string $responseClass,
        public ResponseKind $responseKind = ResponseKind::Json,
        public bool $deprecated = false,
        public ?ConnectionUpgrade $upgrade = null,
    ) {}
}
