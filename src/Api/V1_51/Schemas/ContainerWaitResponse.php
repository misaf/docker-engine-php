<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_51\Schemas;

use Misaf\DockerEngine\Serialization\Undefined;
use Symfony\Component\Serializer\Attribute\SerializedName;

/** OK response to ContainerWait operation */
readonly class ContainerWaitResponse
{
    /**
     * @param ContainerWaitExitError|Undefined $error
     */
    public function __construct(
        #[SerializedName('StatusCode')]
        public int $statusCode,
        #[SerializedName('Error')]
        public ContainerWaitExitError|Undefined $error = Undefined::Value,
    ) {}
}
