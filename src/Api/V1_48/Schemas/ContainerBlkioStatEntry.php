<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_48\Schemas;

use Misaf\DockerEngine\Serialization\Undefined;
use Symfony\Component\Serializer\Attribute\SerializedName;

/** Blkio stats entry. */
readonly class ContainerBlkioStatEntry
{
    public function __construct(
        #[SerializedName('major')]
        public int|Undefined $major = Undefined::Value,
        #[SerializedName('minor')]
        public int|Undefined $minor = Undefined::Value,
        #[SerializedName('op')]
        public string|Undefined $op = Undefined::Value,
        #[SerializedName('value')]
        public int|Undefined $value = Undefined::Value,
    ) {}
}
