<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_45\Schemas;

use Misaf\DockerEngine\Serialization\Undefined;
use Symfony\Component\Serializer\Attribute\SerializedName;

readonly class SystemInfo
{
    /**
     * @param list<list<string>>|Undefined $driverStatus
     * @param PluginsInfo|Undefined $plugins
     * @param RegistryServiceConfig|Undefined $registryConfig
     * @param array<array-key, mixed>|Undefined $genericResources
     * @param list<string>|Undefined $labels
     * @param array<string, mixed>|Undefined $runtimes
     * @param SwarmInfo|Undefined $swarm
     * @param Commit|Undefined $containerdCommit
     * @param Commit|Undefined $runcCommit
     * @param Commit|Undefined $initCommit
     * @param list<string>|Undefined $securityOptions
     * @param list<array<string, mixed>>|Undefined $defaultAddressPools
     * @param list<string>|Undefined $warnings
     * @param list<string>|Undefined $cdiSpecDirs
     */
    public function __construct(
        #[SerializedName('ID')]
        public string|Undefined $id = Undefined::Value,
        #[SerializedName('Containers')]
        public int|Undefined $containers = Undefined::Value,
        #[SerializedName('ContainersRunning')]
        public int|Undefined $containersRunning = Undefined::Value,
        #[SerializedName('ContainersPaused')]
        public int|Undefined $containersPaused = Undefined::Value,
        #[SerializedName('ContainersStopped')]
        public int|Undefined $containersStopped = Undefined::Value,
        #[SerializedName('Images')]
        public int|Undefined $images = Undefined::Value,
        #[SerializedName('Driver')]
        public string|Undefined $driver = Undefined::Value,
        #[SerializedName('DriverStatus')]
        public array|Undefined $driverStatus = Undefined::Value,
        #[SerializedName('DockerRootDir')]
        public string|Undefined $dockerRootDir = Undefined::Value,
        #[SerializedName('Plugins')]
        public PluginsInfo|Undefined $plugins = Undefined::Value,
        #[SerializedName('MemoryLimit')]
        public bool|Undefined $memoryLimit = Undefined::Value,
        #[SerializedName('SwapLimit')]
        public bool|Undefined $swapLimit = Undefined::Value,
        #[SerializedName('KernelMemoryTCP')]
        public bool|Undefined $kernelMemoryTcp = Undefined::Value,
        #[SerializedName('CpuCfsPeriod')]
        public bool|Undefined $cpuCfsPeriod = Undefined::Value,
        #[SerializedName('CpuCfsQuota')]
        public bool|Undefined $cpuCfsQuota = Undefined::Value,
        #[SerializedName('CPUShares')]
        public bool|Undefined $cpuShares = Undefined::Value,
        #[SerializedName('CPUSet')]
        public bool|Undefined $cpuSet = Undefined::Value,
        #[SerializedName('PidsLimit')]
        public bool|Undefined $pidsLimit = Undefined::Value,
        #[SerializedName('OomKillDisable')]
        public bool|Undefined $oomKillDisable = Undefined::Value,
        #[SerializedName('IPv4Forwarding')]
        public bool|Undefined $iPv4Forwarding = Undefined::Value,
        #[SerializedName('BridgeNfIptables')]
        public bool|Undefined $bridgeNfIptables = Undefined::Value,
        #[SerializedName('BridgeNfIp6tables')]
        public bool|Undefined $bridgeNfIp6tables = Undefined::Value,
        #[SerializedName('Debug')]
        public bool|Undefined $debug = Undefined::Value,
        #[SerializedName('NFd')]
        public int|Undefined $nFd = Undefined::Value,
        #[SerializedName('NGoroutines')]
        public int|Undefined $nGoroutines = Undefined::Value,
        #[SerializedName('SystemTime')]
        public string|Undefined $systemTime = Undefined::Value,
        #[SerializedName('LoggingDriver')]
        public string|Undefined $loggingDriver = Undefined::Value,
        #[SerializedName('CgroupDriver')]
        public string|Undefined $cgroupDriver = Undefined::Value,
        #[SerializedName('CgroupVersion')]
        public string|Undefined $cgroupVersion = Undefined::Value,
        #[SerializedName('NEventsListener')]
        public int|Undefined $nEventsListener = Undefined::Value,
        #[SerializedName('KernelVersion')]
        public string|Undefined $kernelVersion = Undefined::Value,
        #[SerializedName('OperatingSystem')]
        public string|Undefined $operatingSystem = Undefined::Value,
        #[SerializedName('OSVersion')]
        public string|Undefined $osVersion = Undefined::Value,
        #[SerializedName('OSType')]
        public string|Undefined $osType = Undefined::Value,
        #[SerializedName('Architecture')]
        public string|Undefined $architecture = Undefined::Value,
        #[SerializedName('NCPU')]
        public int|Undefined $ncpu = Undefined::Value,
        #[SerializedName('MemTotal')]
        public int|Undefined $memTotal = Undefined::Value,
        #[SerializedName('IndexServerAddress')]
        public string|Undefined $indexServerAddress = Undefined::Value,
        #[SerializedName('RegistryConfig')]
        public RegistryServiceConfig|Undefined $registryConfig = Undefined::Value,
        #[SerializedName('GenericResources')]
        public array|Undefined $genericResources = Undefined::Value,
        #[SerializedName('HttpProxy')]
        public string|Undefined $httpProxy = Undefined::Value,
        #[SerializedName('HttpsProxy')]
        public string|Undefined $httpsProxy = Undefined::Value,
        #[SerializedName('NoProxy')]
        public string|Undefined $noProxy = Undefined::Value,
        #[SerializedName('Name')]
        public string|Undefined $name = Undefined::Value,
        #[SerializedName('Labels')]
        public array|Undefined $labels = Undefined::Value,
        #[SerializedName('ExperimentalBuild')]
        public bool|Undefined $experimentalBuild = Undefined::Value,
        #[SerializedName('ServerVersion')]
        public string|Undefined $serverVersion = Undefined::Value,
        #[SerializedName('Runtimes')]
        public array|Undefined $runtimes = Undefined::Value,
        #[SerializedName('DefaultRuntime')]
        public string|Undefined $defaultRuntime = Undefined::Value,
        #[SerializedName('Swarm')]
        public SwarmInfo|Undefined $swarm = Undefined::Value,
        #[SerializedName('LiveRestoreEnabled')]
        public bool|Undefined $liveRestoreEnabled = Undefined::Value,
        #[SerializedName('Isolation')]
        public string|Undefined $isolation = Undefined::Value,
        #[SerializedName('InitBinary')]
        public string|Undefined $initBinary = Undefined::Value,
        #[SerializedName('ContainerdCommit')]
        public Commit|Undefined $containerdCommit = Undefined::Value,
        #[SerializedName('RuncCommit')]
        public Commit|Undefined $runcCommit = Undefined::Value,
        #[SerializedName('InitCommit')]
        public Commit|Undefined $initCommit = Undefined::Value,
        #[SerializedName('SecurityOptions')]
        public array|Undefined $securityOptions = Undefined::Value,
        #[SerializedName('ProductLicense')]
        public string|Undefined $productLicense = Undefined::Value,
        #[SerializedName('DefaultAddressPools')]
        public array|Undefined $defaultAddressPools = Undefined::Value,
        #[SerializedName('Warnings')]
        public array|Undefined $warnings = Undefined::Value,
        #[SerializedName('CDISpecDirs')]
        public array|Undefined $cdiSpecDirs = Undefined::Value,
    ) {}
}
