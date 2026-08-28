<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_43\Schemas;

use Misaf\DockerEngine\Serialization\Undefined;
use Symfony\Component\Serializer\Attribute\SerializedName;

/** Cluster-specific options used to create the volume. */
readonly class ClusterVolumeSpec
{
    /**
     * @param array<string, mixed>|Undefined $accessMode
     */
    public function __construct(
        #[SerializedName('Group')]
        public string|Undefined $group = Undefined::Value,
        #[SerializedName('AccessMode')]
        public array|Undefined $accessMode = Undefined::Value,
    ) {}
}
