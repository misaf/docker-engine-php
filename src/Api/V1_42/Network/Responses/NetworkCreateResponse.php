<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_42\Network\Responses;

use Misaf\DockerEngine\Serialization\Undefined;
use Symfony\Component\Serializer\Attribute\SerializedName;

/** Create a network */
final readonly class NetworkCreateResponse
{
    public function __construct(
        #[SerializedName('Id')]
        public string|Undefined $id = Undefined::Value,
        #[SerializedName('Warning')]
        public string|Undefined $warning = Undefined::Value,
    ) {}
}
