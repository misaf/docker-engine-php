<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_40\Schemas;

use Misaf\DockerEngine\Serialization\Undefined;
use Symfony\Component\Serializer\Attribute\SerializedName;

/** Driver represents a driver (network, logging, secrets). */
readonly class Driver
{
    /**
     * @param array<string, mixed>|Undefined $options
     */
    public function __construct(
        #[SerializedName('Name')]
        public string $name,
        #[SerializedName('Options')]
        public array|Undefined $options = Undefined::Value,
    ) {}
}
