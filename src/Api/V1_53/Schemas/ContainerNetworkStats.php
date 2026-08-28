<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_53\Schemas;

use Misaf\DockerEngine\Serialization\Undefined;
use Symfony\Component\Serializer\Attribute\SerializedName;

/** Aggregates the network stats of one container */
readonly class ContainerNetworkStats
{
    public function __construct(
        #[SerializedName('rx_bytes')]
        public int|Undefined $rxBytes = Undefined::Value,
        #[SerializedName('rx_packets')]
        public int|Undefined $rxPackets = Undefined::Value,
        #[SerializedName('rx_errors')]
        public int|Undefined $rxErrors = Undefined::Value,
        #[SerializedName('rx_dropped')]
        public int|Undefined $rxDropped = Undefined::Value,
        #[SerializedName('tx_bytes')]
        public int|Undefined $txBytes = Undefined::Value,
        #[SerializedName('tx_packets')]
        public int|Undefined $txPackets = Undefined::Value,
        #[SerializedName('tx_errors')]
        public int|Undefined $txErrors = Undefined::Value,
        #[SerializedName('tx_dropped')]
        public int|Undefined $txDropped = Undefined::Value,
        #[SerializedName('endpoint_id')]
        public string|Undefined|null $endpointId = Undefined::Value,
        #[SerializedName('instance_id')]
        public string|Undefined|null $instanceId = Undefined::Value,
    ) {}
}
