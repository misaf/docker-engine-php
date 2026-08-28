<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_41\Schemas;

use Misaf\DockerEngine\Serialization\ArrayOf;
use Misaf\DockerEngine\Serialization\Undefined;
use Symfony\Component\Serializer\Attribute\SerializedName;

/** NetworkSettings exposes the network settings in the API */
readonly class NetworkSettings
{
    /**
     * @param array<array-key, mixed>|Undefined $ports
     * @param list<Address>|Undefined $secondaryIpAddresses
     * @param list<Address>|Undefined $secondaryIPv6Addresses
     * @param array<string, mixed>|Undefined $networks
     */
    public function __construct(
        #[SerializedName('Bridge')]
        public string|Undefined $bridge = Undefined::Value,
        #[SerializedName('SandboxID')]
        public string|Undefined $sandboxId = Undefined::Value,
        #[SerializedName('HairpinMode')]
        public bool|Undefined $hairpinMode = Undefined::Value,
        #[SerializedName('LinkLocalIPv6Address')]
        public string|Undefined $linkLocalIPv6Address = Undefined::Value,
        #[SerializedName('LinkLocalIPv6PrefixLen')]
        public int|Undefined $linkLocalIPv6PrefixLen = Undefined::Value,
        #[SerializedName('Ports')]
        public array|Undefined $ports = Undefined::Value,
        #[SerializedName('SandboxKey')]
        public string|Undefined $sandboxKey = Undefined::Value,
        #[SerializedName('SecondaryIPAddresses')]
        #[ArrayOf(Address::class)]
        public array|Undefined|null $secondaryIpAddresses = Undefined::Value,
        #[SerializedName('SecondaryIPv6Addresses')]
        #[ArrayOf(Address::class)]
        public array|Undefined|null $secondaryIPv6Addresses = Undefined::Value,
        #[SerializedName('EndpointID')]
        public string|Undefined $endpointId = Undefined::Value,
        #[SerializedName('Gateway')]
        public string|Undefined $gateway = Undefined::Value,
        #[SerializedName('GlobalIPv6Address')]
        public string|Undefined $globalIPv6Address = Undefined::Value,
        #[SerializedName('GlobalIPv6PrefixLen')]
        public int|Undefined $globalIPv6PrefixLen = Undefined::Value,
        #[SerializedName('IPAddress')]
        public string|Undefined $ipAddress = Undefined::Value,
        #[SerializedName('IPPrefixLen')]
        public int|Undefined $ipPrefixLen = Undefined::Value,
        #[SerializedName('IPv6Gateway')]
        public string|Undefined $iPv6Gateway = Undefined::Value,
        #[SerializedName('MacAddress')]
        public string|Undefined $macAddress = Undefined::Value,
        #[SerializedName('Networks')]
        public array|Undefined $networks = Undefined::Value,
    ) {}
}
