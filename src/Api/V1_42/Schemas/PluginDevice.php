<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_42\Schemas;

use Symfony\Component\Serializer\Attribute\SerializedName;

readonly class PluginDevice
{
    /**
     * @param list<string> $settable
     */
    public function __construct(
        #[SerializedName('Name')]
        public string $name,
        #[SerializedName('Description')]
        public string $description,
        #[SerializedName('Settable')]
        public array $settable,
        #[SerializedName('Path')]
        public string $path,
    ) {}
}
