<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_54\Schemas;

use Misaf\DockerEngine\Serialization\Undefined;
use Symfony\Component\Serializer\Attribute\SerializedName;

readonly class BuildInfo
{
    /**
     * @param ErrorDetail|Undefined $errorDetail
     * @param ProgressDetail|Undefined $progressDetail
     * @param ImageID|Undefined $aux
     */
    public function __construct(
        #[SerializedName('id')]
        public string|Undefined $id = Undefined::Value,
        #[SerializedName('stream')]
        public string|Undefined $stream = Undefined::Value,
        #[SerializedName('errorDetail')]
        public ErrorDetail|Undefined $errorDetail = Undefined::Value,
        #[SerializedName('status')]
        public string|Undefined $status = Undefined::Value,
        #[SerializedName('progressDetail')]
        public ProgressDetail|Undefined $progressDetail = Undefined::Value,
        #[SerializedName('aux')]
        public ImageID|Undefined $aux = Undefined::Value,
    ) {}
}
