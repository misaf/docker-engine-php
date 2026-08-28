<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_55\Schemas;

use Misaf\DockerEngine\Serialization\Undefined;
use Symfony\Component\Serializer\Attribute\SerializedName;

readonly class SecretSpec
{
    /**
     * @param array<string, mixed>|Undefined $labels
     * @param Driver|Undefined $driver
     * @param Driver|Undefined $templating
     */
    public function __construct(
        #[SerializedName('Name')]
        public string|Undefined $name = Undefined::Value,
        #[SerializedName('Labels')]
        public array|Undefined $labels = Undefined::Value,
        #[SerializedName('Data')]
        public string|Undefined $data = Undefined::Value,
        #[SerializedName('Driver')]
        public Driver|Undefined $driver = Undefined::Value,
        #[SerializedName('Templating')]
        public Driver|Undefined $templating = Undefined::Value,
    ) {}
}
