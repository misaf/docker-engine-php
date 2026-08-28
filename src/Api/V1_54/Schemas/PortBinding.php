<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_54\Schemas;

use Misaf\DockerEngine\Serialization\Undefined;
use Symfony\Component\Serializer\Attribute\SerializedName;

/** PortBinding represents a binding between a host IP address and a host */
readonly class PortBinding
{
    public function __construct(
        #[SerializedName('HostIp')]
        public string|Undefined $hostIp = Undefined::Value,
        #[SerializedName('HostPort')]
        public string|Undefined $hostPort = Undefined::Value,
    ) {}
}
