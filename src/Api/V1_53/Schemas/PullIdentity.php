<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_53\Schemas;

use Misaf\DockerEngine\Serialization\Undefined;
use Symfony\Component\Serializer\Attribute\SerializedName;

/** PullIdentity contains remote location information if image was created via pull. */
readonly class PullIdentity
{
    public function __construct(
        #[SerializedName('Repository')]
        public string|Undefined $repository = Undefined::Value,
    ) {}
}
