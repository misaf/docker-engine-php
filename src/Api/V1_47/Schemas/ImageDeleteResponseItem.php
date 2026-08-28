<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_47\Schemas;

use Misaf\DockerEngine\Serialization\Undefined;
use Symfony\Component\Serializer\Attribute\SerializedName;

readonly class ImageDeleteResponseItem
{
    public function __construct(
        #[SerializedName('Untagged')]
        public string|Undefined $untagged = Undefined::Value,
        #[SerializedName('Deleted')]
        public string|Undefined $deleted = Undefined::Value,
    ) {}
}
