<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_53\Schemas;

use Misaf\DockerEngine\Serialization\Undefined;
use Symfony\Component\Serializer\Attribute\SerializedName;

/** carries the information about one backend task */
readonly class NetworkTaskInfo
{
    /**
     * @param array<string, mixed>|Undefined $info
     */
    public function __construct(
        #[SerializedName('Name')]
        public string|Undefined $name = Undefined::Value,
        #[SerializedName('EndpointID')]
        public string|Undefined $endpointId = Undefined::Value,
        #[SerializedName('EndpointIP')]
        public string|Undefined $endpointIp = Undefined::Value,
        #[SerializedName('Info')]
        public array|Undefined $info = Undefined::Value,
    ) {}
}
