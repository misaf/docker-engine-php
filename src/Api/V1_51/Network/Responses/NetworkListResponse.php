<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_51\Network\Responses;

final readonly class NetworkListResponse
{
    /** @param list<\Misaf\DockerEngine\Api\V1_51\Schemas\Network> $items */
    public function __construct(
        #[\Misaf\DockerEngine\Serialization\ArrayOf(\Misaf\DockerEngine\Api\V1_51\Schemas\Network::class)]
        public array $items,
    ) {}
}
