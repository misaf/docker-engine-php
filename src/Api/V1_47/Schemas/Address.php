<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_47\Schemas;

use Misaf\DockerEngine\Serialization\Undefined;
use Symfony\Component\Serializer\Attribute\SerializedName;

/** Address represents an IPv4 or IPv6 IP address. */
readonly class Address
{
    public function __construct(
        #[SerializedName('Addr')]
        public string|Undefined $addr = Undefined::Value,
        #[SerializedName('PrefixLen')]
        public int|Undefined $prefixLen = Undefined::Value,
    ) {}
}
