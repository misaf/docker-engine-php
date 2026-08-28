<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Dto\System;

final readonly class EngineVersion
{
    public function __construct(
        public string $version,
        public string $apiVersion,
        public string $minimumApiVersion,
        public string $operatingSystem,
        public string $architecture,
    ) {}
}
