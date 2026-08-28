<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_43\Schemas;

use Misaf\DockerEngine\Serialization\Undefined;
use Symfony\Component\Serializer\Attribute\SerializedName;

/** A map of topological domains to topological segments. For in depth */
readonly class Topology
{
    /**
     * @param array<string, mixed>|Undefined $segments
     */
    public function __construct(
        #[SerializedName('Segments')]
        public array|Undefined $segments = Undefined::Value,
    ) {}
}
