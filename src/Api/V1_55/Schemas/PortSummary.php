<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_55\Schemas;

use Misaf\DockerEngine\Serialization\Undefined;
use Symfony\Component\Serializer\Attribute\SerializedName;

/** Describes a port-mapping between the container and the host. */
readonly class PortSummary
{
    public function __construct(
        #[SerializedName('PrivatePort')]
        public int $privatePort,
        #[SerializedName('Type')]
        public string $type,
        #[SerializedName('IP')]
        public string|Undefined $ip = Undefined::Value,
        #[SerializedName('PublicPort')]
        public int|Undefined $publicPort = Undefined::Value,
    ) {}
}
