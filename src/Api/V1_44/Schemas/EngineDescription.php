<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_44\Schemas;

use Misaf\DockerEngine\Serialization\Undefined;
use Symfony\Component\Serializer\Attribute\SerializedName;

/** EngineDescription provides information about an engine. */
readonly class EngineDescription
{
    /**
     * @param array<string, mixed>|Undefined $labels
     * @param list<array<string, mixed>>|Undefined $plugins
     */
    public function __construct(
        #[SerializedName('EngineVersion')]
        public string|Undefined $engineVersion = Undefined::Value,
        #[SerializedName('Labels')]
        public array|Undefined $labels = Undefined::Value,
        #[SerializedName('Plugins')]
        public array|Undefined $plugins = Undefined::Value,
    ) {}
}
