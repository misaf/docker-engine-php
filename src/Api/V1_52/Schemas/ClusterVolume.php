<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_52\Schemas;

use Misaf\DockerEngine\Serialization\Undefined;
use Symfony\Component\Serializer\Attribute\SerializedName;

/** Options and information specific to, and only present on, Swarm CSI */
readonly class ClusterVolume
{
    /**
     * @param ObjectVersion|Undefined $version
     * @param ClusterVolumeSpec|Undefined $spec
     * @param array<string, mixed>|Undefined $info
     * @param list<array<string, mixed>>|Undefined $publishStatus
     */
    public function __construct(
        #[SerializedName('ID')]
        public string|Undefined $id = Undefined::Value,
        #[SerializedName('Version')]
        public ObjectVersion|Undefined $version = Undefined::Value,
        #[SerializedName('CreatedAt')]
        public string|Undefined $createdAt = Undefined::Value,
        #[SerializedName('UpdatedAt')]
        public string|Undefined $updatedAt = Undefined::Value,
        #[SerializedName('Spec')]
        public ClusterVolumeSpec|Undefined $spec = Undefined::Value,
        #[SerializedName('Info')]
        public array|Undefined $info = Undefined::Value,
        #[SerializedName('PublishStatus')]
        public array|Undefined $publishStatus = Undefined::Value,
    ) {}
}
