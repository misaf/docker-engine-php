<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_41\Config\Responses;

final readonly class ConfigListResponse
{
    /** @param list<\Misaf\DockerEngine\Api\V1_41\Schemas\Config> $items */
    public function __construct(
        #[\Misaf\DockerEngine\Serialization\ArrayOf(\Misaf\DockerEngine\Api\V1_41\Schemas\Config::class)]
        public array $items,
    ) {}
}
