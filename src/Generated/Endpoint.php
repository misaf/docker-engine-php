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
        public string $responseKind = 'json',
        public bool $deprecated = false,
        public ?string $upgrade = null,
    ) {}
}
