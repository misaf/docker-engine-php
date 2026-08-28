<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_48\Schemas;

use Misaf\DockerEngine\Serialization\Undefined;
use Symfony\Component\Serializer\Attribute\SerializedName;

/** Container "top" response. */
readonly class ContainerTopResponse
{
    /**
     * @param list<string>|Undefined $titles
     * @param list<list<string>>|Undefined $processes
     */
    public function __construct(
        #[SerializedName('Titles')]
        public array|Undefined $titles = Undefined::Value,
        #[SerializedName('Processes')]
        public array|Undefined $processes = Undefined::Value,
    ) {}
}
