<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_43\Schemas;

use Misaf\DockerEngine\Serialization\Undefined;
use Symfony\Component\Serializer\Attribute\SerializedName;

/** A device mapping between the host and container */
readonly class DeviceMapping
{
    public function __construct(
        #[SerializedName('PathOnHost')]
        public string|Undefined $pathOnHost = Undefined::Value,
        #[SerializedName('PathInContainer')]
        public string|Undefined $pathInContainer = Undefined::Value,
        #[SerializedName('CgroupPermissions')]
        public string|Undefined $cgroupPermissions = Undefined::Value,
    ) {}
}
