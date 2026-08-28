<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_53\System\Responses;

use Misaf\DockerEngine\Serialization\Undefined;
use Symfony\Component\Serializer\Attribute\SerializedName;

/** Get data usage information */
final readonly class SystemDataUsageResponse
{
    /**
     * @param \Misaf\DockerEngine\Api\V1_53\Schemas\ImagesDiskUsage|Undefined $imageUsage
     * @param \Misaf\DockerEngine\Api\V1_53\Schemas\ContainersDiskUsage|Undefined $containerUsage
     * @param \Misaf\DockerEngine\Api\V1_53\Schemas\VolumesDiskUsage|Undefined $volumeUsage
     * @param \Misaf\DockerEngine\Api\V1_53\Schemas\BuildCacheDiskUsage|Undefined $buildCacheUsage
     */
    public function __construct(
        #[SerializedName('ImageUsage')]
        public \Misaf\DockerEngine\Api\V1_53\Schemas\ImagesDiskUsage|Undefined $imageUsage = Undefined::Value,
        #[SerializedName('ContainerUsage')]
        public \Misaf\DockerEngine\Api\V1_53\Schemas\ContainersDiskUsage|Undefined $containerUsage = Undefined::Value,
        #[SerializedName('VolumeUsage')]
        public \Misaf\DockerEngine\Api\V1_53\Schemas\VolumesDiskUsage|Undefined $volumeUsage = Undefined::Value,
        #[SerializedName('BuildCacheUsage')]
        public \Misaf\DockerEngine\Api\V1_53\Schemas\BuildCacheDiskUsage|Undefined $buildCacheUsage = Undefined::Value,
    ) {}
}
