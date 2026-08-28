<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_53\Schemas;

use Misaf\DockerEngine\Serialization\Undefined;
use Symfony\Component\Serializer\Attribute\SerializedName;

readonly class AuthConfig
{
    public function __construct(
        #[SerializedName('username')]
        public string|Undefined $username = Undefined::Value,
        #[SerializedName('password')]
        public string|Undefined $password = Undefined::Value,
        #[SerializedName('serveraddress')]
        public string|Undefined $serveraddress = Undefined::Value,
    ) {}
}
