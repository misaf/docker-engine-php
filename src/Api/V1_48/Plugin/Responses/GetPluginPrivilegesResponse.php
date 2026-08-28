<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_48\Plugin\Responses;

final readonly class GetPluginPrivilegesResponse
{
    /** @param list<\Misaf\DockerEngine\Api\V1_48\Schemas\PluginPrivilege> $items */
    public function __construct(
        #[\Misaf\DockerEngine\Serialization\ArrayOf(\Misaf\DockerEngine\Api\V1_48\Schemas\PluginPrivilege::class)]
        public array $items,
    ) {}
}
