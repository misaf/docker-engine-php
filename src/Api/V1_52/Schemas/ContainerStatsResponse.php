<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_52\Schemas;

use Misaf\DockerEngine\Serialization\Undefined;
use Symfony\Component\Serializer\Attribute\SerializedName;

/** Statistics sample for a container. */
readonly class ContainerStatsResponse
{
    /**
     * @param ContainerCPUStats|Undefined $cpuStats
     * @param ContainerMemoryStats|Undefined $memoryStats
     * @param ContainerPidsStats|Undefined $pidsStats
     * @param ContainerBlkioStats|Undefined $blkioStats
     * @param ContainerStorageStats|Undefined $storageStats
     * @param ContainerCPUStats|Undefined $precpuStats
     */
    public function __construct(
        #[SerializedName('id')]
        public string|Undefined|null $id = Undefined::Value,
        #[SerializedName('name')]
        public string|Undefined|null $name = Undefined::Value,
        #[SerializedName('os_type')]
        public string|Undefined|null $osType = Undefined::Value,
        #[SerializedName('read')]
        public string|Undefined $read = Undefined::Value,
        #[SerializedName('cpu_stats')]
        public ContainerCPUStats|Undefined $cpuStats = Undefined::Value,
        #[SerializedName('memory_stats')]
        public ContainerMemoryStats|Undefined $memoryStats = Undefined::Value,
        #[SerializedName('networks')]
        public mixed $networks = Undefined::Value,
        #[SerializedName('pids_stats')]
        public ContainerPidsStats|Undefined $pidsStats = Undefined::Value,
        #[SerializedName('blkio_stats')]
        public ContainerBlkioStats|Undefined $blkioStats = Undefined::Value,
        #[SerializedName('num_procs')]
        public int|Undefined $numProcs = Undefined::Value,
        #[SerializedName('storage_stats')]
        public ContainerStorageStats|Undefined $storageStats = Undefined::Value,
        #[SerializedName('preread')]
        public string|Undefined $preread = Undefined::Value,
        #[SerializedName('precpu_stats')]
        public ContainerCPUStats|Undefined $precpuStats = Undefined::Value,
    ) {}
}
