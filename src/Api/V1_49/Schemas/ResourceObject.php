<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_49\Schemas;

use Misaf\DockerEngine\Serialization\Undefined;
use Symfony\Component\Serializer\Attribute\SerializedName;

/** An object describing the resources which can be advertised by a node and */
readonly class ResourceObject
{
    /**
     * @param array<array-key, mixed>|Undefined $genericResources
     */
    public function __construct(
        #[SerializedName('NanoCPUs')]
        public int|Undefined $nanoCpUs = Undefined::Value,
        #[SerializedName('MemoryBytes')]
        public int|Undefined $memoryBytes = Undefined::Value,
        #[SerializedName('GenericResources')]
        public array|Undefined $genericResources = Undefined::Value,
    ) {}
}
