<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_54\Schemas;

use Misaf\DockerEngine\Serialization\Undefined;
use Symfony\Component\Serializer\Attribute\SerializedName;

/** BuildIdentity contains build reference information if image was created via build. */
readonly class BuildIdentity
{
    public function __construct(
        #[SerializedName('Ref')]
        public string|Undefined $ref = Undefined::Value,
        #[SerializedName('CreatedAt')]
        public string|Undefined $createdAt = Undefined::Value,
    ) {}
}
