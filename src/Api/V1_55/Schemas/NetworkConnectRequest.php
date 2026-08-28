<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_55\Schemas;

use Misaf\DockerEngine\Serialization\Undefined;
use Symfony\Component\Serializer\Attribute\SerializedName;

/** NetworkConnectRequest represents the data to be used to connect a container to a network. */
readonly class NetworkConnectRequest
{
    /**
     * @param EndpointSettings|Undefined $endpointConfig
     */
    public function __construct(
        #[SerializedName('Container')]
        public string $container,
        #[SerializedName('EndpointConfig')]
        public EndpointSettings|Undefined|null $endpointConfig = Undefined::Value,
    ) {}
}
