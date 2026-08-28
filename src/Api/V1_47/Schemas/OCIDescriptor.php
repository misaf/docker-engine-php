<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_47\Schemas;

use Misaf\DockerEngine\Serialization\Undefined;
use Symfony\Component\Serializer\Attribute\SerializedName;

/** A descriptor struct containing digest, media type, and size, as defined in */
readonly class OCIDescriptor
{
    public function __construct(
        #[SerializedName('mediaType')]
        public string|Undefined $mediaType = Undefined::Value,
        #[SerializedName('digest')]
        public string|Undefined $digest = Undefined::Value,
        #[SerializedName('size')]
        public int|Undefined $size = Undefined::Value,
    ) {}
}
