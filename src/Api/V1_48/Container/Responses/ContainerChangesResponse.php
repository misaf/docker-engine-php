<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_48\Container\Responses;

final readonly class ContainerChangesResponse
{
    /** @param list<\Misaf\DockerEngine\Api\V1_48\Schemas\FilesystemChange> $items */
    public function __construct(
        #[\Misaf\DockerEngine\Serialization\ArrayOf(\Misaf\DockerEngine\Api\V1_48\Schemas\FilesystemChange::class)]
        public array $items,
    ) {}
}
