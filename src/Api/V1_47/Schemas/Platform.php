<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_47\Schemas;

use Misaf\DockerEngine\Serialization\Undefined;
use Symfony\Component\Serializer\Attribute\SerializedName;

/** Platform represents the platform (Arch/OS). */
readonly class Platform
{
    public function __construct(
        #[SerializedName('Architecture')]
        public string|Undefined $architecture = Undefined::Value,
        #[SerializedName('OS')]
        public string|Undefined $os = Undefined::Value,
    ) {}
}
