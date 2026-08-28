<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_49\Schemas;

use Misaf\DockerEngine\Serialization\Undefined;
use Symfony\Component\Serializer\Attribute\SerializedName;

/** NodeStatus represents the status of a node. */
readonly class NodeStatus
{
    /**
     * @param NodeState|Undefined $state
     */
    public function __construct(
        #[SerializedName('State')]
        public NodeState|Undefined $state = Undefined::Value,
        #[SerializedName('Message')]
        public string|Undefined $message = Undefined::Value,
        #[SerializedName('Addr')]
        public string|Undefined $addr = Undefined::Value,
    ) {}
}
