<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_44\Schemas;

use Misaf\DockerEngine\Serialization\Undefined;
use Symfony\Component\Serializer\Attribute\SerializedName;

readonly class PushImageInfo
{
    /**
     * @param ProgressDetail|Undefined $progressDetail
     */
    public function __construct(
        #[SerializedName('error')]
        public string|Undefined $error = Undefined::Value,
        #[SerializedName('status')]
        public string|Undefined $status = Undefined::Value,
        #[SerializedName('progress')]
        public string|Undefined $progress = Undefined::Value,
        #[SerializedName('progressDetail')]
        public ProgressDetail|Undefined $progressDetail = Undefined::Value,
    ) {}
}
