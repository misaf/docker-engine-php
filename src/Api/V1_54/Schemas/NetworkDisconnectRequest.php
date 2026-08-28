<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_54\Schemas;

use Misaf\DockerEngine\Serialization\Undefined;
use Symfony\Component\Serializer\Attribute\SerializedName;

/** NetworkDisconnectRequest represents the data to be used to disconnect a container from a network. */
readonly class NetworkDisconnectRequest
{
    public function __construct(
        #[SerializedName('Container')]
        public string $container,
        #[SerializedName('Force')]
        public bool|Undefined $force = Undefined::Value,
    ) {}
}
