<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_50\Secret\Responses;

final readonly class SecretListResponse
{
    /** @param list<\Misaf\DockerEngine\Api\V1_50\Schemas\Secret> $items */
    public function __construct(
        #[\Misaf\DockerEngine\Serialization\ArrayOf(\Misaf\DockerEngine\Api\V1_50\Schemas\Secret::class)]
        public array $items,
    ) {}
}
