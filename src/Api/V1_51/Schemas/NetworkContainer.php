<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_51\Schemas;

use Misaf\DockerEngine\Serialization\Undefined;
use Symfony\Component\Serializer\Attribute\SerializedName;

readonly class NetworkContainer
{
    public function __construct(
        #[SerializedName('Name')]
        public string|Undefined $name = Undefined::Value,
        #[SerializedName('EndpointID')]
        public string|Undefined $endpointId = Undefined::Value,
        #[SerializedName('MacAddress')]
        public string|Undefined $macAddress = Undefined::Value,
        #[SerializedName('IPv4Address')]
        public string|Undefined $iPv4Address = Undefined::Value,
        #[SerializedName('IPv6Address')]
        public string|Undefined $iPv6Address = Undefined::Value,
    ) {}
}
