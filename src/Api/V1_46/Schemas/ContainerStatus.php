<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_46\Schemas;

use Misaf\DockerEngine\Serialization\Undefined;
use Symfony\Component\Serializer\Attribute\SerializedName;

/** represents the status of a container. */
readonly class ContainerStatus
{
    public function __construct(
        #[SerializedName('ContainerID')]
        public string|Undefined $containerId = Undefined::Value,
        #[SerializedName('PID')]
        public int|Undefined $pid = Undefined::Value,
        #[SerializedName('ExitCode')]
        public int|Undefined $exitCode = Undefined::Value,
    ) {}
}
