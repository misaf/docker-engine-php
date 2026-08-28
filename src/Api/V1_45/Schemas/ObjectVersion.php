<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_45\Schemas;

use Misaf\DockerEngine\Serialization\Undefined;
use Symfony\Component\Serializer\Attribute\SerializedName;

/** The version number of the object such as node, service, etc. This is needed */
readonly class ObjectVersion
{
    public function __construct(
        #[SerializedName('Index')]
        public int|Undefined $index = Undefined::Value,
    ) {}
}
