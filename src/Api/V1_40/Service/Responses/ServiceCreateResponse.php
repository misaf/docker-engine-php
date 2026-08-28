<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_40\Service\Responses;

use Misaf\DockerEngine\Serialization\Undefined;
use Symfony\Component\Serializer\Attribute\SerializedName;

/** Create a service */
final readonly class ServiceCreateResponse
{
    public function __construct(
        #[SerializedName('ID')]
        public string|Undefined $id = Undefined::Value,
        #[SerializedName('Warning')]
        public string|Undefined $warning = Undefined::Value,
    ) {}
}
