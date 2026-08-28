<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_44\Schemas;

use Misaf\DockerEngine\Serialization\ArrayOf;
use Misaf\DockerEngine\Serialization\Undefined;
use Symfony\Component\Serializer\Attribute\SerializedName;

/** Health stores information about the container's healthcheck results. */
readonly class Health
{
    /**
     * @param list<HealthcheckResult>|Undefined $log
     */
    public function __construct(
        #[SerializedName('Status')]
        public string|Undefined $status = Undefined::Value,
        #[SerializedName('FailingStreak')]
        public int|Undefined $failingStreak = Undefined::Value,
        #[SerializedName('Log')]
        #[ArrayOf(HealthcheckResult::class)]
        public array|Undefined $log = Undefined::Value,
    ) {}
}
