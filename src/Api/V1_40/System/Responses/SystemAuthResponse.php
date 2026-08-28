<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_40\System\Responses;

use Misaf\DockerEngine\Serialization\Undefined;
use Symfony\Component\Serializer\Attribute\SerializedName;

/** Check auth configuration */
final readonly class SystemAuthResponse
{
    public function __construct(
        #[SerializedName('Status')]
        public string $status,
        #[SerializedName('IdentityToken')]
        public string|Undefined $identityToken = Undefined::Value,
    ) {}
}
