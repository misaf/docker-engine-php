<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_42\Schemas;

use Misaf\DockerEngine\Serialization\Undefined;
use Symfony\Component\Serializer\Attribute\SerializedName;

/** An open port on a container */
readonly class Port
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
