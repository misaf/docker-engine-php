<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_41\Schemas;

use Misaf\DockerEngine\Serialization\Undefined;
use Symfony\Component\Serializer\Attribute\SerializedName;

/** container waiting error, if any */
readonly class ContainerWaitExitError
{
    public function __construct(
        #[SerializedName('Message')]
        public string|Undefined $message = Undefined::Value,
    ) {}
}
