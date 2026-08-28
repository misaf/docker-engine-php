<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_52\Schemas;

use Misaf\DockerEngine\Serialization\Undefined;
use Symfony\Component\Serializer\Attribute\SerializedName;

/** The config-only network source to provide the configuration for */
readonly class ConfigReference
{
    public function __construct(
        #[SerializedName('Network')]
        public string|Undefined $network = Undefined::Value,
    ) {}
}
