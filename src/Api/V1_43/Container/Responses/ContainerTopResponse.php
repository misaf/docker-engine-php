<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_43\Container\Responses;

use Misaf\DockerEngine\Serialization\Undefined;
use Symfony\Component\Serializer\Attribute\SerializedName;

/** List processes running inside a container */
final readonly class ContainerTopResponse
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
