<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Dto\System;

final readonly class EngineInfo
{
    /** @param array<string, string> $labels */
    public function __construct(
        public string $id,
        public string $name,
        public int $containers,
        public int $containersRunning,
        public int $images,
        public string $operatingSystem,
        public string $architecture,
        public array $labels = [],
    ) {}
}
