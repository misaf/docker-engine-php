<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_55\Schemas;

use Misaf\DockerEngine\Serialization\Undefined;
use Symfony\Component\Serializer\Attribute\SerializedName;

/** An object describing a limit on resources which can be requested by a task. */
readonly class Limit
{
    public function __construct(
        #[SerializedName('NanoCPUs')]
        public int|Undefined $nanoCpUs = Undefined::Value,
        #[SerializedName('MemoryBytes')]
        public int|Undefined $memoryBytes = Undefined::Value,
        #[SerializedName('Pids')]
        public int|Undefined $pids = Undefined::Value,
    ) {}
}
