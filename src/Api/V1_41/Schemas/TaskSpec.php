<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_41\Schemas;

use Misaf\DockerEngine\Serialization\ArrayOf;
use Misaf\DockerEngine\Serialization\Undefined;
use Symfony\Component\Serializer\Attribute\SerializedName;

/** User modifiable task configuration. */
readonly class TaskSpec
{
    /**
     * @param array<string, mixed>|Undefined $pluginSpec
     * @param array<string, mixed>|Undefined $containerSpec
     * @param array<string, mixed>|Undefined $networkAttachmentSpec
     * @param array<string, mixed>|Undefined $resources
     * @param array<string, mixed>|Undefined $restartPolicy
     * @param array<string, mixed>|Undefined $placement
     * @param list<NetworkAttachmentConfig>|Undefined $networks
     * @param array<string, mixed>|Undefined $logDriver
     */
    public function __construct(
        #[SerializedName('PluginSpec')]
        public array|Undefined $pluginSpec = Undefined::Value,
        #[SerializedName('ContainerSpec')]
        public array|Undefined $containerSpec = Undefined::Value,
        #[SerializedName('NetworkAttachmentSpec')]
        public array|Undefined $networkAttachmentSpec = Undefined::Value,
        #[SerializedName('Resources')]
        public array|Undefined $resources = Undefined::Value,
        #[SerializedName('RestartPolicy')]
        public array|Undefined $restartPolicy = Undefined::Value,
        #[SerializedName('Placement')]
        public array|Undefined $placement = Undefined::Value,
        #[SerializedName('ForceUpdate')]
        public int|Undefined $forceUpdate = Undefined::Value,
        #[SerializedName('Runtime')]
        public string|Undefined $runtime = Undefined::Value,
        #[SerializedName('Networks')]
        #[ArrayOf(NetworkAttachmentConfig::class)]
        public array|Undefined $networks = Undefined::Value,
        #[SerializedName('LogDriver')]
        public array|Undefined $logDriver = Undefined::Value,
    ) {}
}
