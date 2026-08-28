<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_53\Schemas;

use Misaf\DockerEngine\Serialization\Undefined;
use Symfony\Component\Serializer\Attribute\SerializedName;

/** An identity token was generated successfully. */
readonly class AuthResponse
{
    public function __construct(
        #[SerializedName('Status')]
        public string $status,
        #[SerializedName('IdentityToken')]
        public string|Undefined $identityToken = Undefined::Value,
    ) {}
}
