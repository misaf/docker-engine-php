<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_48\Schemas;

use Misaf\DockerEngine\Serialization\Undefined;
use Symfony\Component\Serializer\Attribute\SerializedName;

/** All CPU stats aggregated since container inception. */
readonly class ContainerCPUUsage
{
    /**
     * @param list<int>|Undefined $percpuUsage
     */
    public function __construct(
        #[SerializedName('total_usage')]
        public int|Undefined $totalUsage = Undefined::Value,
        #[SerializedName('percpu_usage')]
        public array|Undefined|null $percpuUsage = Undefined::Value,
        #[SerializedName('usage_in_kernelmode')]
        public int|Undefined $usageInKernelmode = Undefined::Value,
        #[SerializedName('usage_in_usermode')]
        public int|Undefined $usageInUsermode = Undefined::Value,
    ) {}
}
