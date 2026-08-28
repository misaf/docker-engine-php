<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_41\Container\Responses;

final readonly class ContainerListResponse
{
    /** @param list<\Misaf\DockerEngine\Api\V1_41\Schemas\ContainerSummary> $items */
    public function __construct(
        #[\Misaf\DockerEngine\Serialization\ArrayOf(\Misaf\DockerEngine\Api\V1_41\Schemas\ContainerSummary::class)]
        public array $items,
    ) {}
}
