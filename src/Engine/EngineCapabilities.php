<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Engine;

use Misaf\DockerEngine\ApiVersion;

final readonly class EngineCapabilities
{
    public function __construct(
        public EngineImplementation $implementation,
        public ApiVersion $apiVersion,
        public bool $supportsSwarm,
        public bool $supportsCheckpoint,
        public bool $supportsExecResize,
        public bool $supportsSession,
        public bool $supportsPlugins,
    ) {}
}
