<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_55\Schemas;

use Misaf\DockerEngine\Serialization\Undefined;
use Symfony\Component\Serializer\Attribute\SerializedName;

/** Aggregates all memory stats since container inception on Linux. */
readonly class ContainerMemoryStats
{
    /**
     * @param array<string, mixed>|Undefined $stats
     */
    public function __construct(
        #[SerializedName('usage')]
        public int|Undefined|null $usage = Undefined::Value,
        #[SerializedName('max_usage')]
        public int|Undefined|null $maxUsage = Undefined::Value,
        #[SerializedName('stats')]
        public array|Undefined $stats = Undefined::Value,
        #[SerializedName('failcnt')]
        public int|Undefined|null $failcnt = Undefined::Value,
        #[SerializedName('limit')]
        public int|Undefined|null $limit = Undefined::Value,
        #[SerializedName('commitbytes')]
        public int|Undefined|null $commitbytes = Undefined::Value,
        #[SerializedName('commitpeakbytes')]
        public int|Undefined|null $commitpeakbytes = Undefined::Value,
        #[SerializedName('privateworkingset')]
        public int|Undefined|null $privateworkingset = Undefined::Value,
    ) {}
}
