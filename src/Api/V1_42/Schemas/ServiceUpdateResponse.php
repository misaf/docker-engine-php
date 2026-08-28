<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_42\Schemas;

use Misaf\DockerEngine\Serialization\Undefined;
use Symfony\Component\Serializer\Attribute\SerializedName;

readonly class ServiceUpdateResponse
{
    /**
     * @param list<string>|Undefined $warnings
     */
    public function __construct(
        #[SerializedName('Warnings')]
        public array|Undefined $warnings = Undefined::Value,
    ) {}
}
