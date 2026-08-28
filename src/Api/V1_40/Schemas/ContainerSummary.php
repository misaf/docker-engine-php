<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_40\Schemas;

use Misaf\DockerEngine\Serialization\ArrayOf;
use Misaf\DockerEngine\Serialization\Undefined;
use Symfony\Component\Serializer\Attribute\SerializedName;

readonly class ContainerSummary
{
    /**
     * @param list<string>|Undefined $names
     * @param list<Port>|Undefined $ports
     * @param array<string, mixed>|Undefined $labels
     * @param array<string, mixed>|Undefined $hostConfig
     * @param array<string, mixed>|Undefined $networkSettings
     * @param list<MountPoint>|Undefined $mounts
     */
    public function __construct(
        #[SerializedName('Id')]
        public string|Undefined $id = Undefined::Value,
        #[SerializedName('Names')]
        public array|Undefined $names = Undefined::Value,
        #[SerializedName('Image')]
        public string|Undefined $image = Undefined::Value,
        #[SerializedName('ImageID')]
        public string|Undefined $imageId = Undefined::Value,
        #[SerializedName('Command')]
        public string|Undefined $command = Undefined::Value,
        #[SerializedName('Created')]
        public int|Undefined $created = Undefined::Value,
        #[SerializedName('Ports')]
        #[ArrayOf(Port::class)]
        public array|Undefined $ports = Undefined::Value,
        #[SerializedName('SizeRw')]
        public int|Undefined $sizeRw = Undefined::Value,
        #[SerializedName('SizeRootFs')]
        public int|Undefined $sizeRootFs = Undefined::Value,
        #[SerializedName('Labels')]
        public array|Undefined $labels = Undefined::Value,
        #[SerializedName('State')]
        public string|Undefined $state = Undefined::Value,
        #[SerializedName('Status')]
        public string|Undefined $status = Undefined::Value,
        #[SerializedName('HostConfig')]
        public array|Undefined $hostConfig = Undefined::Value,
        #[SerializedName('NetworkSettings')]
        public array|Undefined $networkSettings = Undefined::Value,
        #[SerializedName('Mounts')]
        #[ArrayOf(MountPoint::class)]
        public array|Undefined $mounts = Undefined::Value,
    ) {}
}
