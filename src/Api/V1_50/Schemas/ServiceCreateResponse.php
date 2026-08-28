<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_50\Schemas;

use Misaf\DockerEngine\Serialization\Undefined;
use Symfony\Component\Serializer\Attribute\SerializedName;

/** contains the information returned to a client on the */
readonly class ServiceCreateResponse
{
    /**
     * @param list<string>|Undefined $warnings
     */
    public function __construct(
        #[SerializedName('ID')]
        public string|Undefined $id = Undefined::Value,
        #[SerializedName('Warnings')]
        public array|Undefined|null $warnings = Undefined::Value,
    ) {}
}
