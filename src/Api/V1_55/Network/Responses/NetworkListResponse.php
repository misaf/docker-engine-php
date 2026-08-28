<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_55\Network\Responses;

final readonly class NetworkListResponse
{
    /** @param list<\Misaf\DockerEngine\Api\V1_55\Schemas\NetworkSummary> $items */
    public function __construct(
        #[\Misaf\DockerEngine\Serialization\ArrayOf(\Misaf\DockerEngine\Api\V1_55\Schemas\NetworkSummary::class)]
        public array $items,
    ) {}
}
