<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_52\Schemas;

use Misaf\DockerEngine\Serialization\Undefined;
use Symfony\Component\Serializer\Attribute\SerializedName;

/** NetworkSettings exposes the network settings in the API */
readonly class NetworkSettings
{
    /**
     * @param array<array-key, mixed>|Undefined $ports
     * @param array<string, mixed>|Undefined $networks
     */
    public function __construct(
        #[SerializedName('SandboxID')]
        public string|Undefined $sandboxId = Undefined::Value,
        #[SerializedName('SandboxKey')]
        public string|Undefined $sandboxKey = Undefined::Value,
        #[SerializedName('Ports')]
        public array|Undefined $ports = Undefined::Value,
        #[SerializedName('Networks')]
        public array|Undefined $networks = Undefined::Value,
    ) {}
}
