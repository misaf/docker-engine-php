<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Dto\Container;

use Misaf\DockerEngine\ValueObjects\ContainerId;

final readonly class ContainerInfo
{
    /**
     * @param array<string, mixed> $configuration
     * @param array<string, mixed> $hostConfiguration
     */
    public function __construct(
        public ContainerId $id,
        public string $name,
        public string $image,
        public string $state,
        public bool $running,
        public array $configuration = [],
        public array $hostConfiguration = [],
    ) {}
}
