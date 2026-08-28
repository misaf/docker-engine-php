<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_54\Schemas;

use Misaf\DockerEngine\Serialization\Undefined;
use Symfony\Component\Serializer\Attribute\SerializedName;

/** Runtime describes an [OCI compliant](https://github.com/opencontainers/runtime-spec) */
readonly class Runtime
{
    /**
     * @param list<string>|Undefined $runtimeArgs
     * @param array<string, mixed>|Undefined $status
     */
    public function __construct(
        #[SerializedName('path')]
        public string|Undefined $path = Undefined::Value,
        #[SerializedName('runtimeArgs')]
        public array|Undefined|null $runtimeArgs = Undefined::Value,
        #[SerializedName('status')]
        public array|Undefined|null $status = Undefined::Value,
    ) {}
}
