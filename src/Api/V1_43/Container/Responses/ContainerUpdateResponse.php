<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_43\Container\Responses;

use Misaf\DockerEngine\Serialization\Undefined;
use Symfony\Component\Serializer\Attribute\SerializedName;

/** Update a container */
final readonly class ContainerUpdateResponse
{
    /**
     * @param list<string>|Undefined $warnings
     */
    public function __construct(
        #[SerializedName('Warnings')]
        public array|Undefined $warnings = Undefined::Value,
    ) {}
}
