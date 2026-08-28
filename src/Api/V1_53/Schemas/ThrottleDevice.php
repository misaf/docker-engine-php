<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_53\Schemas;

use Misaf\DockerEngine\Serialization\Undefined;
use Symfony\Component\Serializer\Attribute\SerializedName;

readonly class ThrottleDevice
{
    public function __construct(
        #[SerializedName('Path')]
        public string|Undefined $path = Undefined::Value,
        #[SerializedName('Rate')]
        public int|Undefined $rate = Undefined::Value,
    ) {}
}
