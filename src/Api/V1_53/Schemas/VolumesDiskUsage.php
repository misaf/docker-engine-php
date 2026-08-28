<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_53\Schemas;

use Misaf\DockerEngine\Serialization\Undefined;
use Symfony\Component\Serializer\Attribute\SerializedName;

/** represents system data usage for volume resources. */
readonly class VolumesDiskUsage
{
    /**
     * @param list<mixed>|Undefined $items
     */
    public function __construct(
        #[SerializedName('ActiveCount')]
        public int|Undefined $activeCount = Undefined::Value,
        #[SerializedName('TotalCount')]
        public int|Undefined $totalCount = Undefined::Value,
        #[SerializedName('Reclaimable')]
        public int|Undefined $reclaimable = Undefined::Value,
        #[SerializedName('TotalSize')]
        public int|Undefined $totalSize = Undefined::Value,
        #[SerializedName('Items')]
        public array|Undefined $items = Undefined::Value,
    ) {}
}
