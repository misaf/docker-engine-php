<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_50\Schemas;

use Misaf\DockerEngine\Serialization\Undefined;
use Symfony\Component\Serializer\Attribute\SerializedName;

/** NodeDescription encapsulates the properties of the Node as reported by the */
readonly class NodeDescription
{
    /**
     * @param Platform|Undefined $platform
     * @param ResourceObject|Undefined $resources
     * @param EngineDescription|Undefined $engine
     * @param TLSInfo|Undefined $tlsInfo
     */
    public function __construct(
        #[SerializedName('Hostname')]
        public string|Undefined $hostname = Undefined::Value,
        #[SerializedName('Platform')]
        public Platform|Undefined $platform = Undefined::Value,
        #[SerializedName('Resources')]
        public ResourceObject|Undefined $resources = Undefined::Value,
        #[SerializedName('Engine')]
        public EngineDescription|Undefined $engine = Undefined::Value,
        #[SerializedName('TLSInfo')]
        public TLSInfo|Undefined $tlsInfo = Undefined::Value,
    ) {}
}
