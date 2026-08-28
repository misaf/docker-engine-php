<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_50\Schemas;

use Misaf\DockerEngine\Serialization\Undefined;
use Symfony\Component\Serializer\Attribute\SerializedName;

/** Image ID or Digest */
readonly class ImageID
{
    public function __construct(
        #[SerializedName('ID')]
        public string|Undefined $id = Undefined::Value,
    ) {}
}
