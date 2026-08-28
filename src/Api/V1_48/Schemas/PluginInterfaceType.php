<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_48\Schemas;

use Symfony\Component\Serializer\Attribute\SerializedName;

readonly class PluginInterfaceType
{
    public function __construct(
        #[SerializedName('Prefix')]
        public string $prefix,
        #[SerializedName('Capability')]
        public string $capability,
        #[SerializedName('Version')]
        public string $version,
    ) {}
}
