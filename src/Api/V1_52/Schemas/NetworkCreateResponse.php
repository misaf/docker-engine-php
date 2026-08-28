<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_52\Schemas;

use Symfony\Component\Serializer\Attribute\SerializedName;

/** OK response to NetworkCreate operation */
readonly class NetworkCreateResponse
{
    public function __construct(
        #[SerializedName('Id')]
        public string $id,
        #[SerializedName('Warning')]
        public string $warning,
    ) {}
}
