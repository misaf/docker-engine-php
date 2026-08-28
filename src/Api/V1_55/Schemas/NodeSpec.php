<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_55\Schemas;

use Misaf\DockerEngine\Serialization\Undefined;
use Symfony\Component\Serializer\Attribute\SerializedName;

readonly class NodeSpec
{
    /**
     * @param array<string, mixed>|Undefined $labels
     */
    public function __construct(
        #[SerializedName('Name')]
        public string|Undefined $name = Undefined::Value,
        #[SerializedName('Labels')]
        public array|Undefined $labels = Undefined::Value,
        #[SerializedName('Role')]
        public string|Undefined $role = Undefined::Value,
        #[SerializedName('Availability')]
        public string|Undefined $availability = Undefined::Value,
    ) {}
}
