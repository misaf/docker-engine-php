<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Dto\Container;

use Misaf\DockerEngine\ValueObjects\ContainerId;

final readonly class ContainerSummary
{
    /**
     * @param list<string> $names
     * @param array<string, string> $labels
     */
    public function __construct(
        public ContainerId $id,
        public array $names,
        public string $image,
        public string $state,
        public string $status,
        public array $labels = [],
    ) {}
}
