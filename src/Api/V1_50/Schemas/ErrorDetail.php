<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_50\Schemas;

use Misaf\DockerEngine\Serialization\Undefined;
use Symfony\Component\Serializer\Attribute\SerializedName;

readonly class ErrorDetail
{
    public function __construct(
        #[SerializedName('code')]
        public int|Undefined $code = Undefined::Value,
        #[SerializedName('message')]
        public string|Undefined $message = Undefined::Value,
    ) {}
}
