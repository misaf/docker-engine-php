<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_49\Schemas;

use Misaf\DockerEngine\Serialization\Undefined;
use Symfony\Component\Serializer\Attribute\SerializedName;

readonly class Volume
{
    /**
     * @param array<string, mixed> $labels
     * @param array<string, mixed> $options
     * @param array<string, mixed>|Undefined $status
     * @param ClusterVolume|Undefined $clusterVolume
     * @param array<string, mixed>|Undefined $usageData
     */
    public function __construct(
        #[SerializedName('Name')]
        public string $name,
        #[SerializedName('Driver')]
        public string $driver,
        #[SerializedName('Mountpoint')]
        public string $mountpoint,
        #[SerializedName('Labels')]
        public array $labels,
        #[SerializedName('Scope')]
        public string $scope,
        #[SerializedName('Options')]
        public array $options,
        #[SerializedName('CreatedAt')]
        public string|Undefined $createdAt = Undefined::Value,
        #[SerializedName('Status')]
        public array|Undefined $status = Undefined::Value,
        #[SerializedName('ClusterVolume')]
        public ClusterVolume|Undefined $clusterVolume = Undefined::Value,
        #[SerializedName('UsageData')]
        public array|Undefined|null $usageData = Undefined::Value,
    ) {}
}
