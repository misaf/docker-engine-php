<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_53\Schemas;

use Misaf\DockerEngine\Serialization\Undefined;
use Symfony\Component\Serializer\Attribute\SerializedName;

/** Information for connecting to the containerd instance that is used by the daemon. */
readonly class ContainerdInfo
{
    /**
     * @param array<string, mixed>|Undefined $namespaces
     */
    public function __construct(
        #[SerializedName('Address')]
        public string|Undefined $address = Undefined::Value,
        #[SerializedName('Namespaces')]
        public array|Undefined $namespaces = Undefined::Value,
    ) {}
}
