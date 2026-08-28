<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_50\Schemas;

use Misaf\DockerEngine\Serialization\ArrayOf;
use Misaf\DockerEngine\Serialization\Undefined;
use Symfony\Component\Serializer\Attribute\SerializedName;

/** Represents generic information about swarm. */
readonly class SwarmInfo
{
    /**
     * @param LocalNodeState|Undefined $localNodeState
     * @param list<PeerNode>|Undefined $remoteManagers
     * @param ClusterInfo|Undefined $cluster
     */
    public function __construct(
        #[SerializedName('NodeID')]
        public string|Undefined $nodeId = Undefined::Value,
        #[SerializedName('NodeAddr')]
        public string|Undefined $nodeAddr = Undefined::Value,
        #[SerializedName('LocalNodeState')]
        public LocalNodeState|Undefined $localNodeState = Undefined::Value,
        #[SerializedName('ControlAvailable')]
        public bool|Undefined $controlAvailable = Undefined::Value,
        #[SerializedName('Error')]
        public string|Undefined $error = Undefined::Value,
        #[SerializedName('RemoteManagers')]
        #[ArrayOf(PeerNode::class)]
        public array|Undefined|null $remoteManagers = Undefined::Value,
        #[SerializedName('Nodes')]
        public int|Undefined|null $nodes = Undefined::Value,
        #[SerializedName('Managers')]
        public int|Undefined|null $managers = Undefined::Value,
        #[SerializedName('Cluster')]
        public ClusterInfo|Undefined $cluster = Undefined::Value,
    ) {}
}
