<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_48\Schemas;

use Misaf\DockerEngine\Serialization\Undefined;
use Symfony\Component\Serializer\Attribute\SerializedName;

/** represents the status of a task. */
readonly class TaskStatus
{
    /**
     * @param TaskState|Undefined $state
     * @param ContainerStatus|Undefined $containerStatus
     * @param PortStatus|Undefined $portStatus
     */
    public function __construct(
        #[SerializedName('Timestamp')]
        public string|Undefined $timestamp = Undefined::Value,
        #[SerializedName('State')]
        public TaskState|Undefined $state = Undefined::Value,
        #[SerializedName('Message')]
        public string|Undefined $message = Undefined::Value,
        #[SerializedName('Err')]
        public string|Undefined $err = Undefined::Value,
        #[SerializedName('ContainerStatus')]
        public ContainerStatus|Undefined $containerStatus = Undefined::Value,
        #[SerializedName('PortStatus')]
        public PortStatus|Undefined $portStatus = Undefined::Value,
    ) {}
}
