<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_52\Schemas;

use Misaf\DockerEngine\Serialization\ArrayOf;
use Misaf\DockerEngine\Serialization\Undefined;
use Symfony\Component\Serializer\Attribute\SerializedName;

readonly class ContainerInspectResponse
{
    /**
     * @param list<string>|Undefined $args
     * @param ContainerState|Undefined $state
     * @param OCIDescriptor|Undefined $imageManifestDescriptor
     * @param list<string>|Undefined $execIDs
     * @param HostConfig|Undefined $hostConfig
     * @param DriverData|Undefined $graphDriver
     * @param Storage|Undefined $storage
     * @param list<MountPoint>|Undefined $mounts
     * @param ContainerConfig|Undefined $config
     * @param NetworkSettings|Undefined $networkSettings
     */
    public function __construct(
        #[SerializedName('Id')]
        public string|Undefined $id = Undefined::Value,
        #[SerializedName('Created')]
        public string|Undefined|null $created = Undefined::Value,
        #[SerializedName('Path')]
        public string|Undefined $path = Undefined::Value,
        #[SerializedName('Args')]
        public array|Undefined $args = Undefined::Value,
        #[SerializedName('State')]
        public ContainerState|Undefined $state = Undefined::Value,
        #[SerializedName('Image')]
        public string|Undefined $image = Undefined::Value,
        #[SerializedName('ResolvConfPath')]
        public string|Undefined $resolvConfPath = Undefined::Value,
        #[SerializedName('HostnamePath')]
        public string|Undefined $hostnamePath = Undefined::Value,
        #[SerializedName('HostsPath')]
        public string|Undefined $hostsPath = Undefined::Value,
        #[SerializedName('LogPath')]
        public string|Undefined|null $logPath = Undefined::Value,
        #[SerializedName('Name')]
        public string|Undefined $name = Undefined::Value,
        #[SerializedName('RestartCount')]
        public int|Undefined $restartCount = Undefined::Value,
        #[SerializedName('Driver')]
        public string|Undefined $driver = Undefined::Value,
        #[SerializedName('Platform')]
        public string|Undefined $platform = Undefined::Value,
        #[SerializedName('ImageManifestDescriptor')]
        public OCIDescriptor|Undefined $imageManifestDescriptor = Undefined::Value,
        #[SerializedName('MountLabel')]
        public string|Undefined $mountLabel = Undefined::Value,
        #[SerializedName('ProcessLabel')]
        public string|Undefined $processLabel = Undefined::Value,
        #[SerializedName('AppArmorProfile')]
        public string|Undefined $appArmorProfile = Undefined::Value,
        #[SerializedName('ExecIDs')]
        public array|Undefined|null $execIDs = Undefined::Value,
        #[SerializedName('HostConfig')]
        public HostConfig|Undefined $hostConfig = Undefined::Value,
        #[SerializedName('GraphDriver')]
        public DriverData|Undefined|null $graphDriver = Undefined::Value,
        #[SerializedName('Storage')]
        public Storage|Undefined|null $storage = Undefined::Value,
        #[SerializedName('SizeRw')]
        public int|Undefined|null $sizeRw = Undefined::Value,
        #[SerializedName('SizeRootFs')]
        public int|Undefined|null $sizeRootFs = Undefined::Value,
        #[SerializedName('Mounts')]
        #[ArrayOf(MountPoint::class)]
        public array|Undefined $mounts = Undefined::Value,
        #[SerializedName('Config')]
        public ContainerConfig|Undefined $config = Undefined::Value,
        #[SerializedName('NetworkSettings')]
        public NetworkSettings|Undefined $networkSettings = Undefined::Value,
    ) {}
}
