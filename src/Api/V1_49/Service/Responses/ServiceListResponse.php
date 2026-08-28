<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_49\Service\Responses;

final readonly class ServiceListResponse
{
    /** @param list<\Misaf\DockerEngine\Api\V1_49\Schemas\Service> $items */
    public function __construct(
        #[\Misaf\DockerEngine\Serialization\ArrayOf(\Misaf\DockerEngine\Api\V1_49\Schemas\Service::class)]
        public array $items,
    ) {}
}
