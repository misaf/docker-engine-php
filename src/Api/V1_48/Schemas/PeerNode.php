<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_48\Schemas;

use Misaf\DockerEngine\Serialization\Undefined;
use Symfony\Component\Serializer\Attribute\SerializedName;

/** Represents a peer-node in the swarm */
readonly class PeerNode
{
    public function __construct(
        #[SerializedName('NodeID')]
        public string|Undefined $nodeId = Undefined::Value,
        #[SerializedName('Addr')]
        public string|Undefined $addr = Undefined::Value,
    ) {}
}
