<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_44\Schemas;

use Misaf\DockerEngine\Serialization\ArrayOf;
use Misaf\DockerEngine\Serialization\Undefined;
use Symfony\Component\Serializer\Attribute\SerializedName;

/** represents the port status of a task's host ports whose service has published host ports */
readonly class PortStatus
{
    /**
     * @param list<EndpointPortConfig>|Undefined $ports
     */
    public function __construct(
        #[SerializedName('Ports')]
        #[ArrayOf(EndpointPortConfig::class)]
        public array|Undefined $ports = Undefined::Value,
    ) {}
}
