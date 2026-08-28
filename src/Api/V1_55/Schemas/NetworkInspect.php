<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_55\Schemas;

use Misaf\DockerEngine\Serialization\ArrayOf;
use Misaf\DockerEngine\Serialization\Undefined;
use Symfony\Component\Serializer\Attribute\SerializedName;

/** The body of the "get network" http response message. */
readonly class NetworkInspect
{
    /**
     * @param IPAM|Undefined $ipam
     * @param ConfigReference|Undefined $configFrom
     * @param array<string, mixed>|Undefined $options
     * @param array<string, mixed>|Undefined $labels
     * @param list<PeerInfo>|Undefined $peers
     * @param array<string, mixed>|Undefined $containers
     * @param array<string, mixed>|Undefined $services
     * @param NetworkStatus|Undefined $status
     */
    public function __construct(
        #[SerializedName('Name')]
        public string|Undefined $name = Undefined::Value,
        #[SerializedName('Id')]
        public string|Undefined $id = Undefined::Value,
        #[SerializedName('Created')]
        public string|Undefined $created = Undefined::Value,
        #[SerializedName('Scope')]
        public string|Undefined $scope = Undefined::Value,
        #[SerializedName('Driver')]
        public string|Undefined $driver = Undefined::Value,
        #[SerializedName('EnableIPv4')]
        public bool|Undefined $enableIPv4 = Undefined::Value,
        #[SerializedName('EnableIPv6')]
        public bool|Undefined $enableIPv6 = Undefined::Value,
        #[SerializedName('IPAM')]
        public IPAM|Undefined $ipam = Undefined::Value,
        #[SerializedName('Internal')]
        public bool|Undefined $internal = Undefined::Value,
        #[SerializedName('Attachable')]
        public bool|Undefined $attachable = Undefined::Value,
        #[SerializedName('Ingress')]
        public bool|Undefined $ingress = Undefined::Value,
        #[SerializedName('ConfigFrom')]
        public ConfigReference|Undefined $configFrom = Undefined::Value,
        #[SerializedName('ConfigOnly')]
        public bool|Undefined $configOnly = Undefined::Value,
        #[SerializedName('Options')]
        public array|Undefined $options = Undefined::Value,
        #[SerializedName('Labels')]
        public array|Undefined $labels = Undefined::Value,
        #[SerializedName('Peers')]
        #[ArrayOf(PeerInfo::class)]
        public array|Undefined $peers = Undefined::Value,
        #[SerializedName('Containers')]
        public array|Undefined $containers = Undefined::Value,
        #[SerializedName('Services')]
        public array|Undefined $services = Undefined::Value,
        #[SerializedName('Status')]
        public NetworkStatus|Undefined $status = Undefined::Value,
    ) {}
}
