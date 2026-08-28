<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_41\Schemas;

use Misaf\DockerEngine\Serialization\ArrayOf;
use Misaf\DockerEngine\Serialization\Undefined;
use Symfony\Component\Serializer\Attribute\SerializedName;

readonly class IPAM
{
    /**
     * @param list<IPAMConfig>|Undefined $config
     * @param array<string, mixed>|Undefined $options
     */
    public function __construct(
        #[SerializedName('Driver')]
        public string|Undefined $driver = Undefined::Value,
        #[SerializedName('Config')]
        #[ArrayOf(IPAMConfig::class)]
        public array|Undefined $config = Undefined::Value,
        #[SerializedName('Options')]
        public array|Undefined $options = Undefined::Value,
    ) {}
}
