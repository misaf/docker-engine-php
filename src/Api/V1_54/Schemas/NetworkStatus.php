<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_54\Schemas;

use Misaf\DockerEngine\Serialization\Undefined;
use Symfony\Component\Serializer\Attribute\SerializedName;

/** provides runtime information about the network such as the number of allocated IPs. */
readonly class NetworkStatus
{
    /**
     * @param IPAMStatus|Undefined $ipam
     */
    public function __construct(
        #[SerializedName('IPAM')]
        public IPAMStatus|Undefined $ipam = Undefined::Value,
    ) {}
}
