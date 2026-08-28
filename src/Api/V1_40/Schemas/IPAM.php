<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_40\Schemas;

use Misaf\DockerEngine\Serialization\Undefined;
use Symfony\Component\Serializer\Attribute\SerializedName;

readonly class IPAM
{
    /**
     * @param list<array<string, mixed>>|Undefined $config
     * @param array<string, mixed>|Undefined $options
     */
    public function __construct(
        #[SerializedName('Driver')]
        public string|Undefined $driver = Undefined::Value,
        #[SerializedName('Config')]
        public array|Undefined $config = Undefined::Value,
        #[SerializedName('Options')]
        public array|Undefined $options = Undefined::Value,
    ) {}
}
