<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_55\Schemas;

use Misaf\DockerEngine\Serialization\Undefined;
use Symfony\Component\Serializer\Attribute\SerializedName;

readonly class PushImageInfo
{
    /**
     * @param ErrorDetail|Undefined $errorDetail
     * @param ProgressDetail|Undefined $progressDetail
     */
    public function __construct(
        #[SerializedName('errorDetail')]
        public ErrorDetail|Undefined $errorDetail = Undefined::Value,
        #[SerializedName('status')]
        public string|Undefined $status = Undefined::Value,
        #[SerializedName('progressDetail')]
        public ProgressDetail|Undefined $progressDetail = Undefined::Value,
    ) {}
}
