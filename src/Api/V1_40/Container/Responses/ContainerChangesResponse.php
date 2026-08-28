<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_40\Container\Responses;

final readonly class ContainerChangesResponse
{
    /** @param list<array<string, mixed>> $items */
    public function __construct(
        public array $items,
    ) {}
}
