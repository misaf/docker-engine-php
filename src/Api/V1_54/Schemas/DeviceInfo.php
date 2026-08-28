<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_54\Schemas;

use Misaf\DockerEngine\Serialization\Undefined;
use Symfony\Component\Serializer\Attribute\SerializedName;

/** DeviceInfo represents a device that can be used by a container. */
readonly class DeviceInfo
{
    public function __construct(
        #[SerializedName('Source')]
        public string|Undefined $source = Undefined::Value,
        #[SerializedName('ID')]
        public string|Undefined $id = Undefined::Value,
    ) {}
}
