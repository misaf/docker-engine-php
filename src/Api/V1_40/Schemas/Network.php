<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_40\Schemas;

use Misaf\DockerEngine\Serialization\Undefined;
use Symfony\Component\Serializer\Attribute\SerializedName;

readonly class Network
{
    /**
     * @param IPAM|Undefined $ipam
     * @param array<string, mixed>|Undefined $containers
     * @param array<string, mixed>|Undefined $options
     * @param array<string, mixed>|Undefined $labels
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
        #[SerializedName('Containers')]
        public array|Undefined $containers = Undefined::Value,
        #[SerializedName('Options')]
        public array|Undefined $options = Undefined::Value,
        #[SerializedName('Labels')]
        public array|Undefined $labels = Undefined::Value,
    ) {}
}
