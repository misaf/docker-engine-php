<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_46\Schemas;

use Misaf\DockerEngine\Serialization\Undefined;
use Symfony\Component\Serializer\Attribute\SerializedName;

readonly class IPAMConfig
{
    /**
     * @param array<string, mixed>|Undefined $auxiliaryAddresses
     */
    public function __construct(
        #[SerializedName('Subnet')]
        public string|Undefined $subnet = Undefined::Value,
        #[SerializedName('IPRange')]
        public string|Undefined $ipRange = Undefined::Value,
        #[SerializedName('Gateway')]
        public string|Undefined $gateway = Undefined::Value,
        #[SerializedName('AuxiliaryAddresses')]
        public array|Undefined $auxiliaryAddresses = Undefined::Value,
    ) {}
}
