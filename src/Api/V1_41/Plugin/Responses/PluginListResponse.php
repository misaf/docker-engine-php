<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_41\Plugin\Responses;

final readonly class PluginListResponse
{
    /** @param list<\Misaf\DockerEngine\Api\V1_41\Schemas\Plugin> $items */
    public function __construct(
        #[\Misaf\DockerEngine\Serialization\ArrayOf(\Misaf\DockerEngine\Api\V1_41\Schemas\Plugin::class)]
        public array $items,
    ) {}
}
