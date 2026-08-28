<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_40\Container\Responses;

use Misaf\DockerEngine\Serialization\ArrayOf;
use Misaf\DockerEngine\Serialization\Undefined;
use Symfony\Component\Serializer\Attribute\SerializedName;

/** Inspect a container */
final readonly class ContainerInspectResponse
{
    /**
     * @param list<string>|Undefined $args
     * @param \Misaf\DockerEngine\Api\V1_40\Schemas\ContainerState|Undefined $state
     * @param list<string>|Undefined $execIDs
     * @param \Misaf\DockerEngine\Api\V1_40\Schemas\HostConfig|Undefined $hostConfig
     * @param \Misaf\DockerEngine\Api\V1_40\Schemas\GraphDriverData|Undefined $graphDriver
     * @param list<\Misaf\DockerEngine\Api\V1_40\Schemas\MountPoint>|Undefined $mounts
     * @param \Misaf\DockerEngine\Api\V1_40\Schemas\ContainerConfig|Undefined $config
     * @param \Misaf\DockerEngine\Api\V1_40\Schemas\NetworkSettings|Undefined $networkSettings
     */
    public function __construct(
        #[SerializedName('Id')]
        public string|Undefined $id = Undefined::Value,
        #[SerializedName('Created')]
        public string|Undefined $created = Undefined::Value,
        #[SerializedName('Path')]
        public string|Undefined $path = Undefined::Value,
        #[SerializedName('Args')]
        public array|Undefined $args = Undefined::Value,
        #[SerializedName('State')]
        public \Misaf\DockerEngine\Api\V1_40\Schemas\ContainerState|Undefined $state = Undefined::Value,
        #[SerializedName('Image')]
        public string|Undefined $image = Undefined::Value,
        #[SerializedName('ResolvConfPath')]
        public string|Undefined $resolvConfPath = Undefined::Value,
        #[SerializedName('HostnamePath')]
        public string|Undefined $hostnamePath = Undefined::Value,
        #[SerializedName('HostsPath')]
        public string|Undefined $hostsPath = Undefined::Value,
        #[SerializedName('LogPath')]
        public string|Undefined $logPath = Undefined::Value,
        #[SerializedName('Name')]
        public string|Undefined $name = Undefined::Value,
        #[SerializedName('RestartCount')]
        public int|Undefined $restartCount = Undefined::Value,
        #[SerializedName('Driver')]
        public string|Undefined $driver = Undefined::Value,
        #[SerializedName('Platform')]
        public string|Undefined $platform = Undefined::Value,
        #[SerializedName('MountLabel')]
        public string|Undefined $mountLabel = Undefined::Value,
        #[SerializedName('ProcessLabel')]
        public string|Undefined $processLabel = Undefined::Value,
        #[SerializedName('AppArmorProfile')]
        public string|Undefined $appArmorProfile = Undefined::Value,
        #[SerializedName('ExecIDs')]
        public array|Undefined|null $execIDs = Undefined::Value,
        #[SerializedName('HostConfig')]
        public \Misaf\DockerEngine\Api\V1_40\Schemas\HostConfig|Undefined $hostConfig = Undefined::Value,
        #[SerializedName('GraphDriver')]
        public \Misaf\DockerEngine\Api\V1_40\Schemas\GraphDriverData|Undefined $graphDriver = Undefined::Value,
        #[SerializedName('SizeRw')]
        public int|Undefined $sizeRw = Undefined::Value,
        #[SerializedName('SizeRootFs')]
        public int|Undefined $sizeRootFs = Undefined::Value,
        #[SerializedName('Mounts')]
        #[ArrayOf(\Misaf\DockerEngine\Api\V1_40\Schemas\MountPoint::class)]
        public array|Undefined $mounts = Undefined::Value,
        #[SerializedName('Config')]
        public \Misaf\DockerEngine\Api\V1_40\Schemas\ContainerConfig|Undefined $config = Undefined::Value,
        #[SerializedName('NetworkSettings')]
        public \Misaf\DockerEngine\Api\V1_40\Schemas\NetworkSettings|Undefined $networkSettings = Undefined::Value,
    ) {}
}
