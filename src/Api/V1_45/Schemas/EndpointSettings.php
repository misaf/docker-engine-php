<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_45\Schemas;

use Misaf\DockerEngine\Serialization\Undefined;
use Symfony\Component\Serializer\Attribute\SerializedName;

/** Configuration for a network endpoint. */
readonly class EndpointSettings
{
    /**
     * @param EndpointIPAMConfig|Undefined $ipamConfig
     * @param list<string>|Undefined $links
     * @param list<string>|Undefined $aliases
     * @param array<string, mixed>|Undefined $driverOpts
     * @param list<string>|Undefined $dnsNames
     */
    public function __construct(
        #[SerializedName('IPAMConfig')]
        public EndpointIPAMConfig|Undefined $ipamConfig = Undefined::Value,
        #[SerializedName('Links')]
        public array|Undefined $links = Undefined::Value,
        #[SerializedName('MacAddress')]
        public string|Undefined $macAddress = Undefined::Value,
        #[SerializedName('Aliases')]
        public array|Undefined $aliases = Undefined::Value,
        #[SerializedName('NetworkID')]
        public string|Undefined $networkId = Undefined::Value,
        #[SerializedName('EndpointID')]
        public string|Undefined $endpointId = Undefined::Value,
        #[SerializedName('Gateway')]
        public string|Undefined $gateway = Undefined::Value,
        #[SerializedName('IPAddress')]
        public string|Undefined $ipAddress = Undefined::Value,
        #[SerializedName('IPPrefixLen')]
        public int|Undefined $ipPrefixLen = Undefined::Value,
        #[SerializedName('IPv6Gateway')]
        public string|Undefined $iPv6Gateway = Undefined::Value,
        #[SerializedName('GlobalIPv6Address')]
        public string|Undefined $globalIPv6Address = Undefined::Value,
        #[SerializedName('GlobalIPv6PrefixLen')]
        public int|Undefined $globalIPv6PrefixLen = Undefined::Value,
        #[SerializedName('DriverOpts')]
        public array|Undefined|null $driverOpts = Undefined::Value,
        #[SerializedName('DNSNames')]
        public array|Undefined $dnsNames = Undefined::Value,
    ) {}
}
