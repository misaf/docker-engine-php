<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_43\Schemas;

use Misaf\DockerEngine\Serialization\Undefined;
use Symfony\Component\Serializer\Attribute\SerializedName;

/** NetworkingConfig represents the container's networking configuration for */
readonly class NetworkingConfig
{
    /**
     * @param array<string, mixed>|Undefined $endpointsConfig
     */
    public function __construct(
        #[SerializedName('EndpointsConfig')]
        public array|Undefined $endpointsConfig = Undefined::Value,
    ) {}
}
