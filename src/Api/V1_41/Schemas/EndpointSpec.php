<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_41\Schemas;

use Misaf\DockerEngine\Serialization\ArrayOf;
use Misaf\DockerEngine\Serialization\Undefined;
use Symfony\Component\Serializer\Attribute\SerializedName;

/** Properties that can be configured to access and load balance a service. */
readonly class EndpointSpec
{
    /**
     * @param list<EndpointPortConfig>|Undefined $ports
     */
    public function __construct(
        #[SerializedName('Mode')]
        public string|Undefined $mode = Undefined::Value,
        #[SerializedName('Ports')]
        #[ArrayOf(EndpointPortConfig::class)]
        public array|Undefined $ports = Undefined::Value,
    ) {}
}
