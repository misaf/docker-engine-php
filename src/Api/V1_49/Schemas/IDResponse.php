<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_49\Schemas;

use Symfony\Component\Serializer\Attribute\SerializedName;

/** Response to an API call that returns just an Id */
readonly class IDResponse
{
    public function __construct(
        #[SerializedName('Id')]
        public string $id,
    ) {}
}
