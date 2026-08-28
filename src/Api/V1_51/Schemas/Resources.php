<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_51\Schemas;

use Misaf\DockerEngine\Serialization\ArrayOf;
use Misaf\DockerEngine\Serialization\Undefined;
use Symfony\Component\Serializer\Attribute\SerializedName;

/** A container's resources (cgroups config, ulimits, etc) */
readonly class Resources
{
    /**
     * @param list<array<string, mixed>>|Undefined $blkioWeightDevice
     * @param list<ThrottleDevice>|Undefined $blkioDeviceReadBps
     * @param list<ThrottleDevice>|Undefined $blkioDeviceWriteBps
     * @param list<ThrottleDevice>|Undefined $blkioDeviceReadIOps
     * @param list<ThrottleDevice>|Undefined $blkioDeviceWriteIOps
     * @param list<DeviceMapping>|Undefined $devices
     * @param list<string>|Undefined $deviceCgroupRules
     * @param list<DeviceRequest>|Undefined $deviceRequests
     * @param list<array<string, mixed>>|Undefined $ulimits
     */
    public function __construct(
        #[SerializedName('CpuShares')]
        public int|Undefined $cpuShares = Undefined::Value,
        #[SerializedName('Memory')]
        public int|Undefined $memory = Undefined::Value,
        #[SerializedName('CgroupParent')]
        public string|Undefined $cgroupParent = Undefined::Value,
        #[SerializedName('BlkioWeight')]
        public int|Undefined $blkioWeight = Undefined::Value,
        #[SerializedName('BlkioWeightDevice')]
        public array|Undefined $blkioWeightDevice = Undefined::Value,
        #[SerializedName('BlkioDeviceReadBps')]
        #[ArrayOf(ThrottleDevice::class)]
        public array|Undefined $blkioDeviceReadBps = Undefined::Value,
        #[SerializedName('BlkioDeviceWriteBps')]
        #[ArrayOf(ThrottleDevice::class)]
        public array|Undefined $blkioDeviceWriteBps = Undefined::Value,
        #[SerializedName('BlkioDeviceReadIOps')]
        #[ArrayOf(ThrottleDevice::class)]
        public array|Undefined $blkioDeviceReadIOps = Undefined::Value,
        #[SerializedName('BlkioDeviceWriteIOps')]
        #[ArrayOf(ThrottleDevice::class)]
        public array|Undefined $blkioDeviceWriteIOps = Undefined::Value,
        #[SerializedName('CpuPeriod')]
        public int|Undefined $cpuPeriod = Undefined::Value,
        #[SerializedName('CpuQuota')]
        public int|Undefined $cpuQuota = Undefined::Value,
        #[SerializedName('CpuRealtimePeriod')]
        public int|Undefined $cpuRealtimePeriod = Undefined::Value,
        #[SerializedName('CpuRealtimeRuntime')]
        public int|Undefined $cpuRealtimeRuntime = Undefined::Value,
        #[SerializedName('CpusetCpus')]
        public string|Undefined $cpusetCpus = Undefined::Value,
        #[SerializedName('CpusetMems')]
        public string|Undefined $cpusetMems = Undefined::Value,
        #[SerializedName('Devices')]
        #[ArrayOf(DeviceMapping::class)]
        public array|Undefined $devices = Undefined::Value,
        #[SerializedName('DeviceCgroupRules')]
        public array|Undefined $deviceCgroupRules = Undefined::Value,
        #[SerializedName('DeviceRequests')]
        #[ArrayOf(DeviceRequest::class)]
        public array|Undefined $deviceRequests = Undefined::Value,
        #[SerializedName('KernelMemoryTCP')]
        public int|Undefined $kernelMemoryTcp = Undefined::Value,
        #[SerializedName('MemoryReservation')]
        public int|Undefined $memoryReservation = Undefined::Value,
        #[SerializedName('MemorySwap')]
        public int|Undefined $memorySwap = Undefined::Value,
        #[SerializedName('MemorySwappiness')]
        public int|Undefined $memorySwappiness = Undefined::Value,
        #[SerializedName('NanoCpus')]
        public int|Undefined $nanoCpus = Undefined::Value,
        #[SerializedName('OomKillDisable')]
        public bool|Undefined $oomKillDisable = Undefined::Value,
        #[SerializedName('Init')]
        public bool|Undefined|null $init = Undefined::Value,
        #[SerializedName('PidsLimit')]
        public int|Undefined|null $pidsLimit = Undefined::Value,
        #[SerializedName('Ulimits')]
        public array|Undefined $ulimits = Undefined::Value,
        #[SerializedName('CpuCount')]
        public int|Undefined $cpuCount = Undefined::Value,
        #[SerializedName('CpuPercent')]
        public int|Undefined $cpuPercent = Undefined::Value,
        #[SerializedName('IOMaximumIOps')]
        public int|Undefined $ioMaximumIOps = Undefined::Value,
        #[SerializedName('IOMaximumBandwidth')]
        public int|Undefined $ioMaximumBandwidth = Undefined::Value,
    ) {}
}
