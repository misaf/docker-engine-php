<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_52\Schemas;

use Misaf\DockerEngine\Serialization\Undefined;
use Symfony\Component\Serializer\Attribute\SerializedName;

/** PidsStats contains Linux-specific stats of a container's process-IDs (PIDs). */
readonly class ContainerPidsStats
{
    public function __construct(
        #[SerializedName('current')]
        public int|Undefined|null $current = Undefined::Value,
        #[SerializedName('limit')]
        public int|Undefined|null $limit = Undefined::Value,
    ) {}
}
