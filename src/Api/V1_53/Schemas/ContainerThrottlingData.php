<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_53\Schemas;

use Misaf\DockerEngine\Serialization\Undefined;
use Symfony\Component\Serializer\Attribute\SerializedName;

/** CPU throttling stats of the container. */
readonly class ContainerThrottlingData
{
    public function __construct(
        #[SerializedName('periods')]
        public int|Undefined $periods = Undefined::Value,
        #[SerializedName('throttled_periods')]
        public int|Undefined $throttledPeriods = Undefined::Value,
        #[SerializedName('throttled_time')]
        public int|Undefined $throttledTime = Undefined::Value,
    ) {}
}
