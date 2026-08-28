<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_46\Schemas;

use Symfony\Component\Serializer\Attribute\SerializedName;

/** Change in the container's filesystem. */
readonly class FilesystemChange
{
    /**
     * @param ChangeType $kind
     */
    public function __construct(
        #[SerializedName('Path')]
        public string $path,
        #[SerializedName('Kind')]
        public ChangeType $kind,
    ) {}
}
