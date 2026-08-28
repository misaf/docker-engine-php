<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_50\Schemas;

use Misaf\DockerEngine\Serialization\Undefined;
use Symfony\Component\Serializer\Attribute\SerializedName;

/** EndpointIPAMConfig represents an endpoint's IPAM configuration. */
readonly class EndpointIPAMConfig
{
    /**
     * @param list<string>|Undefined $linkLocalIPs
     */
    public function __construct(
        #[SerializedName('IPv4Address')]
        public string|Undefined $iPv4Address = Undefined::Value,
        #[SerializedName('IPv6Address')]
        public string|Undefined $iPv6Address = Undefined::Value,
        #[SerializedName('LinkLocalIPs')]
        public array|Undefined $linkLocalIPs = Undefined::Value,
    ) {}
}
