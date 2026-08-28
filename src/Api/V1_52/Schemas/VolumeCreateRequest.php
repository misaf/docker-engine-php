<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_52\Schemas;

use Misaf\DockerEngine\Serialization\Undefined;
use Symfony\Component\Serializer\Attribute\SerializedName;

/** Volume configuration */
readonly class VolumeCreateRequest
{
    /**
     * @param array<string, mixed>|Undefined $driverOpts
     * @param array<string, mixed>|Undefined $labels
     * @param ClusterVolumeSpec|Undefined $clusterVolumeSpec
     */
    public function __construct(
        #[SerializedName('Name')]
        public string|Undefined $name = Undefined::Value,
        #[SerializedName('Driver')]
        public string|Undefined $driver = Undefined::Value,
        #[SerializedName('DriverOpts')]
        public array|Undefined $driverOpts = Undefined::Value,
        #[SerializedName('Labels')]
        public array|Undefined $labels = Undefined::Value,
        #[SerializedName('ClusterVolumeSpec')]
        public ClusterVolumeSpec|Undefined $clusterVolumeSpec = Undefined::Value,
    ) {}
}
