<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_48\Schemas;

use Misaf\DockerEngine\Serialization\Undefined;
use Symfony\Component\Serializer\Attribute\SerializedName;

/** CPU related info of the container */
readonly class ContainerCPUStats
{
    /**
     * @param ContainerCPUUsage|Undefined $cpuUsage
     * @param ContainerThrottlingData|Undefined $throttlingData
     */
    public function __construct(
        #[SerializedName('cpu_usage')]
        public ContainerCPUUsage|Undefined $cpuUsage = Undefined::Value,
        #[SerializedName('system_cpu_usage')]
        public int|Undefined|null $systemCpuUsage = Undefined::Value,
        #[SerializedName('online_cpus')]
        public int|Undefined|null $onlineCpus = Undefined::Value,
        #[SerializedName('throttling_data')]
        public ContainerThrottlingData|Undefined $throttlingData = Undefined::Value,
    ) {}
}
