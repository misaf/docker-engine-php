<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_53\Schemas;

use Misaf\DockerEngine\Serialization\Undefined;
use Symfony\Component\Serializer\Attribute\SerializedName;

/** Information about the Node Resource Interface (NRI). */
readonly class NRIInfo
{
    /**
     * @param list<list<string>>|Undefined $info
     */
    public function __construct(
        #[SerializedName('Info')]
        public array|Undefined $info = Undefined::Value,
    ) {}
}
