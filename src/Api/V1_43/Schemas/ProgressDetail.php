<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_43\Schemas;

use Misaf\DockerEngine\Serialization\Undefined;
use Symfony\Component\Serializer\Attribute\SerializedName;

readonly class ProgressDetail
{
    public function __construct(
        #[SerializedName('current')]
        public int|Undefined $current = Undefined::Value,
        #[SerializedName('total')]
        public int|Undefined $total = Undefined::Value,
    ) {}
}
