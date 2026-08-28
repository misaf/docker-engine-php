<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_48\Schemas;

use Misaf\DockerEngine\Serialization\Undefined;
use Symfony\Component\Serializer\Attribute\SerializedName;

/** The behavior to apply when the container exits. The default is not to */
readonly class RestartPolicy
{
    public function __construct(
        #[SerializedName('Name')]
        public string|Undefined $name = Undefined::Value,
        #[SerializedName('MaximumRetryCount')]
        public int|Undefined $maximumRetryCount = Undefined::Value,
    ) {}
}
