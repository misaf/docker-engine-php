<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_43\Schemas;

use Symfony\Component\Serializer\Attribute\SerializedName;

/** Represents an error. */
readonly class ErrorResponse
{
    public function __construct(
        #[SerializedName('message')]
        public string $message,
    ) {}
}
