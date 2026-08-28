<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_52\Schemas;

use Misaf\DockerEngine\Serialization\ArrayOf;
use Misaf\DockerEngine\Serialization\Undefined;
use Symfony\Component\Serializer\Attribute\SerializedName;

/** represents service parameters with the list of service's tasks */
readonly class ServiceInfo
{
    /**
     * @param list<string>|Undefined $ports
     * @param list<NetworkTaskInfo>|Undefined $tasks
     */
    public function __construct(
        #[SerializedName('VIP')]
        public string|Undefined $vip = Undefined::Value,
        #[SerializedName('Ports')]
        public array|Undefined $ports = Undefined::Value,
        #[SerializedName('LocalLBIndex')]
        public int|Undefined $localLbIndex = Undefined::Value,
        #[SerializedName('Tasks')]
        #[ArrayOf(NetworkTaskInfo::class)]
        public array|Undefined $tasks = Undefined::Value,
    ) {}
}
