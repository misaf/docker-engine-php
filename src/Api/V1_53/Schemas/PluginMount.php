<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_53\Schemas;

use Symfony\Component\Serializer\Attribute\SerializedName;

readonly class PluginMount
{
    /**
     * @param list<string> $settable
     * @param list<string> $options
     */
    public function __construct(
        #[SerializedName('Name')]
        public string $name,
        #[SerializedName('Description')]
        public string $description,
        #[SerializedName('Settable')]
        public array $settable,
        #[SerializedName('Source')]
        public string $source,
        #[SerializedName('Destination')]
        public string $destination,
        #[SerializedName('Type')]
        public string $type,
        #[SerializedName('Options')]
        public array $options,
    ) {}
}
