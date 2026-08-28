<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_46\Schemas;

use Misaf\DockerEngine\Serialization\Undefined;
use Symfony\Component\Serializer\Attribute\SerializedName;

/** HealthcheckResult stores information about a single run of a healthcheck probe */
readonly class HealthcheckResult
{
    public function __construct(
        #[SerializedName('Start')]
        public string|Undefined $start = Undefined::Value,
        #[SerializedName('End')]
        public string|Undefined $end = Undefined::Value,
        #[SerializedName('ExitCode')]
        public int|Undefined $exitCode = Undefined::Value,
        #[SerializedName('Output')]
        public string|Undefined $output = Undefined::Value,
    ) {}
}
