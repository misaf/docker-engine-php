<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_43\Schemas;

use Misaf\DockerEngine\Serialization\Undefined;
use Symfony\Component\Serializer\Attribute\SerializedName;

/** A plugin for the Engine API */
readonly class Plugin
{
    /**
     * @param array<string, mixed> $settings
     * @param array<string, mixed> $config
     */
    public function __construct(
        #[SerializedName('Name')]
        public string $name,
        #[SerializedName('Enabled')]
        public bool $enabled,
        #[SerializedName('Settings')]
        public array $settings,
        #[SerializedName('Config')]
        public array $config,
        #[SerializedName('Id')]
        public string|Undefined $id = Undefined::Value,
        #[SerializedName('PluginReference')]
        public string|Undefined $pluginReference = Undefined::Value,
    ) {}
}
