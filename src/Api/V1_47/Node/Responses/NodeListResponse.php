<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_47\Node\Responses;

final readonly class NodeListResponse
{
    /** @param list<\Misaf\DockerEngine\Api\V1_47\Schemas\Node> $items */
    public function __construct(
        #[\Misaf\DockerEngine\Serialization\ArrayOf(\Misaf\DockerEngine\Api\V1_47\Schemas\Node::class)]
        public array $items,
    ) {}
}
