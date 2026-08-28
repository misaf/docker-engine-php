<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_50\Schemas;

use Misaf\DockerEngine\Serialization\ArrayOf;
use Misaf\DockerEngine\Serialization\Undefined;
use Symfony\Component\Serializer\Attribute\SerializedName;

/** Container configuration that depends on the host we are running on */
readonly class HostConfig
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
     * @param list<string>|Undefined $binds
     * @param array<string, mixed>|Undefined $logConfig
     * @param array<array-key, mixed>|Undefined $portBindings
     * @param RestartPolicy|Undefined $restartPolicy
     * @param list<string>|Undefined $volumesFrom
     * @param list<Mount>|Undefined $mounts
     * @param list<int>|Undefined $consoleSize
     * @param array<string, mixed>|Undefined $annotations
     * @param list<string>|Undefined $capAdd
     * @param list<string>|Undefined $capDrop
     * @param list<string>|Undefined $dns
     * @param list<string>|Undefined $dnsOptions
     * @param list<string>|Undefined $dnsSearch
     * @param list<string>|Undefined $extraHosts
     * @param list<string>|Undefined $groupAdd
     * @param list<string>|Undefined $links
     * @param list<string>|Undefined $securityOpt
     * @param array<string, mixed>|Undefined $storageOpt
     * @param array<string, mixed>|Undefined $tmpfs
     * @param array<string, mixed>|Undefined $sysctls
     * @param list<string>|Undefined $maskedPaths
     * @param list<string>|Undefined $readonlyPaths
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
        #[SerializedName('Binds')]
        public array|Undefined $binds = Undefined::Value,
        #[SerializedName('ContainerIDFile')]
        public string|Undefined $containerIdFile = Undefined::Value,
        #[SerializedName('LogConfig')]
        public array|Undefined $logConfig = Undefined::Value,
        #[SerializedName('NetworkMode')]
        public string|Undefined $networkMode = Undefined::Value,
        #[SerializedName('PortBindings')]
        public array|Undefined $portBindings = Undefined::Value,
        #[SerializedName('RestartPolicy')]
        public RestartPolicy|Undefined $restartPolicy = Undefined::Value,
        #[SerializedName('AutoRemove')]
        public bool|Undefined $autoRemove = Undefined::Value,
        #[SerializedName('VolumeDriver')]
        public string|Undefined $volumeDriver = Undefined::Value,
        #[SerializedName('VolumesFrom')]
        public array|Undefined $volumesFrom = Undefined::Value,
        #[SerializedName('Mounts')]
        #[ArrayOf(Mount::class)]
        public array|Undefined $mounts = Undefined::Value,
        #[SerializedName('ConsoleSize')]
        public array|Undefined|null $consoleSize = Undefined::Value,
        #[SerializedName('Annotations')]
        public array|Undefined $annotations = Undefined::Value,
        #[SerializedName('CapAdd')]
        public array|Undefined $capAdd = Undefined::Value,
        #[SerializedName('CapDrop')]
        public array|Undefined $capDrop = Undefined::Value,
        #[SerializedName('CgroupnsMode')]
        public string|Undefined $cgroupnsMode = Undefined::Value,
        #[SerializedName('Dns')]
        public array|Undefined $dns = Undefined::Value,
        #[SerializedName('DnsOptions')]
        public array|Undefined $dnsOptions = Undefined::Value,
        #[SerializedName('DnsSearch')]
        public array|Undefined $dnsSearch = Undefined::Value,
        #[SerializedName('ExtraHosts')]
        public array|Undefined $extraHosts = Undefined::Value,
        #[SerializedName('GroupAdd')]
        public array|Undefined $groupAdd = Undefined::Value,
        #[SerializedName('IpcMode')]
        public string|Undefined $ipcMode = Undefined::Value,
        #[SerializedName('Cgroup')]
        public string|Undefined $cgroup = Undefined::Value,
        #[SerializedName('Links')]
        public array|Undefined $links = Undefined::Value,
        #[SerializedName('OomScoreAdj')]
        public int|Undefined $oomScoreAdj = Undefined::Value,
        #[SerializedName('PidMode')]
        public string|Undefined $pidMode = Undefined::Value,
        #[SerializedName('Privileged')]
        public bool|Undefined $privileged = Undefined::Value,
        #[SerializedName('PublishAllPorts')]
        public bool|Undefined $publishAllPorts = Undefined::Value,
        #[SerializedName('ReadonlyRootfs')]
        public bool|Undefined $readonlyRootfs = Undefined::Value,
        #[SerializedName('SecurityOpt')]
        public array|Undefined $securityOpt = Undefined::Value,
        #[SerializedName('StorageOpt')]
        public array|Undefined $storageOpt = Undefined::Value,
        #[SerializedName('Tmpfs')]
        public array|Undefined $tmpfs = Undefined::Value,
        #[SerializedName('UTSMode')]
        public string|Undefined $utsMode = Undefined::Value,
        #[SerializedName('UsernsMode')]
        public string|Undefined $usernsMode = Undefined::Value,
        #[SerializedName('ShmSize')]
        public int|Undefined $shmSize = Undefined::Value,
        #[SerializedName('Sysctls')]
        public array|Undefined|null $sysctls = Undefined::Value,
        #[SerializedName('Runtime')]
        public string|Undefined|null $runtime = Undefined::Value,
        #[SerializedName('Isolation')]
        public string|Undefined $isolation = Undefined::Value,
        #[SerializedName('MaskedPaths')]
        public array|Undefined $maskedPaths = Undefined::Value,
        #[SerializedName('ReadonlyPaths')]
        public array|Undefined $readonlyPaths = Undefined::Value,
    ) {}
}
