<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_53\Schemas;

use Misaf\DockerEngine\Serialization\Undefined;
use Symfony\Component\Serializer\Attribute\SerializedName;

/** Information about the storage used by the container. */
readonly class Storage
{
    /**
     * @param RootFSStorage|Undefined $rootFs
     */
    public function __construct(
        #[SerializedName('RootFS')]
        public RootFSStorage|Undefined|null $rootFs = Undefined::Value,
    ) {}
}
