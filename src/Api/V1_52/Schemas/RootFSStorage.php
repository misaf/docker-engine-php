<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_52\Schemas;

use Misaf\DockerEngine\Serialization\Undefined;
use Symfony\Component\Serializer\Attribute\SerializedName;

/** Information about the storage used for the container's root filesystem. */
readonly class RootFSStorage
{
    /**
     * @param RootFSStorageSnapshot|Undefined $snapshot
     */
    public function __construct(
        #[SerializedName('Snapshot')]
        public RootFSStorageSnapshot|Undefined|null $snapshot = Undefined::Value,
    ) {}
}
