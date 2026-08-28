<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_40\System\Responses;

use Misaf\DockerEngine\Serialization\ArrayOf;
use Misaf\DockerEngine\Serialization\Undefined;
use Symfony\Component\Serializer\Attribute\SerializedName;

/** Get data usage information */
final readonly class SystemDataUsageResponse
{
    /**
     * @param list<\Misaf\DockerEngine\Api\V1_40\Schemas\ImageSummary>|Undefined $images
     * @param list<\Misaf\DockerEngine\Api\V1_40\Schemas\ContainerSummary>|Undefined $containers
     * @param list<\Misaf\DockerEngine\Api\V1_40\Schemas\Volume>|Undefined $volumes
     * @param list<\Misaf\DockerEngine\Api\V1_40\Schemas\BuildCache>|Undefined $buildCache
     */
    public function __construct(
        #[SerializedName('LayersSize')]
        public int|Undefined $layersSize = Undefined::Value,
        #[SerializedName('Images')]
        #[ArrayOf(\Misaf\DockerEngine\Api\V1_40\Schemas\ImageSummary::class)]
        public array|Undefined $images = Undefined::Value,
        #[SerializedName('Containers')]
        #[ArrayOf(\Misaf\DockerEngine\Api\V1_40\Schemas\ContainerSummary::class)]
        public array|Undefined $containers = Undefined::Value,
        #[SerializedName('Volumes')]
        #[ArrayOf(\Misaf\DockerEngine\Api\V1_40\Schemas\Volume::class)]
        public array|Undefined $volumes = Undefined::Value,
        #[SerializedName('BuildCache')]
        #[ArrayOf(\Misaf\DockerEngine\Api\V1_40\Schemas\BuildCache::class)]
        public array|Undefined $buildCache = Undefined::Value,
    ) {}
}
