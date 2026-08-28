<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_55\Schemas;

use Misaf\DockerEngine\Serialization\Undefined;
use Symfony\Component\Serializer\Attribute\SerializedName;

readonly class SubnetStatus
{
    public function __construct(
        #[SerializedName('IPsInUse')]
        public int|Undefined $iPsInUse = Undefined::Value,
        #[SerializedName('DynamicIPsAvailable')]
        public int|Undefined $dynamicIPsAvailable = Undefined::Value,
    ) {}
}
