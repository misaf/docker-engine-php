<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_52\Schemas;

use Misaf\DockerEngine\Serialization\Undefined;
use Symfony\Component\Serializer\Attribute\SerializedName;

/** Information about a snapshot backend of the container's root filesystem. */
readonly class RootFSStorageSnapshot
{
    public function __construct(
        #[SerializedName('Name')]
        public string|Undefined $name = Undefined::Value,
    ) {}
}
