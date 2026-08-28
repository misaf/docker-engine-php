<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_40\Schemas;

use Misaf\DockerEngine\Serialization\Undefined;
use Symfony\Component\Serializer\Attribute\SerializedName;

/** BuildCache contains information about a build cache record. */
readonly class BuildCache
{
    public function __construct(
        #[SerializedName('ID')]
        public string|Undefined $id = Undefined::Value,
        #[SerializedName('Parent')]
        public string|Undefined $parent = Undefined::Value,
        #[SerializedName('Type')]
        public string|Undefined $type = Undefined::Value,
        #[SerializedName('Description')]
        public string|Undefined $description = Undefined::Value,
        #[SerializedName('InUse')]
        public bool|Undefined $inUse = Undefined::Value,
        #[SerializedName('Shared')]
        public bool|Undefined $shared = Undefined::Value,
        #[SerializedName('Size')]
        public int|Undefined $size = Undefined::Value,
        #[SerializedName('CreatedAt')]
        public string|Undefined $createdAt = Undefined::Value,
        #[SerializedName('LastUsedAt')]
        public string|Undefined|null $lastUsedAt = Undefined::Value,
        #[SerializedName('UsageCount')]
        public int|Undefined $usageCount = Undefined::Value,
    ) {}
}
