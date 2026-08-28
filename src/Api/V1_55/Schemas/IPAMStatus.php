<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_55\Schemas;

use Misaf\DockerEngine\Serialization\Undefined;
use Symfony\Component\Serializer\Attribute\SerializedName;

readonly class IPAMStatus
{
    /**
     * @param array<string, mixed>|Undefined $subnets
     */
    public function __construct(
        #[SerializedName('Subnets')]
        public array|Undefined $subnets = Undefined::Value,
    ) {}
}
