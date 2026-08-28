<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_52\Schemas;

use Misaf\DockerEngine\Serialization\Undefined;
use Symfony\Component\Serializer\Attribute\SerializedName;

/** A test to perform to check that the container is healthy. */
readonly class HealthConfig
{
    /**
     * @param list<string>|Undefined $test
     */
    public function __construct(
        #[SerializedName('Test')]
        public array|Undefined $test = Undefined::Value,
        #[SerializedName('Interval')]
        public int|Undefined $interval = Undefined::Value,
        #[SerializedName('Timeout')]
        public int|Undefined $timeout = Undefined::Value,
        #[SerializedName('Retries')]
        public int|Undefined $retries = Undefined::Value,
        #[SerializedName('StartPeriod')]
        public int|Undefined $startPeriod = Undefined::Value,
        #[SerializedName('StartInterval')]
        public int|Undefined $startInterval = Undefined::Value,
    ) {}
}
