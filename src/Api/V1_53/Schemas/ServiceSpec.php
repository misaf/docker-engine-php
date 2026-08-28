<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_53\Schemas;

use Misaf\DockerEngine\Serialization\ArrayOf;
use Misaf\DockerEngine\Serialization\Undefined;
use Symfony\Component\Serializer\Attribute\SerializedName;

/** User modifiable configuration for a service. */
readonly class ServiceSpec
{
    /**
     * @param array<string, mixed>|Undefined $labels
     * @param TaskSpec|Undefined $taskTemplate
     * @param array<string, mixed>|Undefined $mode
     * @param array<string, mixed>|Undefined $updateConfig
     * @param array<string, mixed>|Undefined $rollbackConfig
     * @param list<NetworkAttachmentConfig>|Undefined $networks
     * @param EndpointSpec|Undefined $endpointSpec
     */
    public function __construct(
        #[SerializedName('Name')]
        public string|Undefined $name = Undefined::Value,
        #[SerializedName('Labels')]
        public array|Undefined $labels = Undefined::Value,
        #[SerializedName('TaskTemplate')]
        public TaskSpec|Undefined $taskTemplate = Undefined::Value,
        #[SerializedName('Mode')]
        public array|Undefined $mode = Undefined::Value,
        #[SerializedName('UpdateConfig')]
        public array|Undefined $updateConfig = Undefined::Value,
        #[SerializedName('RollbackConfig')]
        public array|Undefined $rollbackConfig = Undefined::Value,
        #[SerializedName('Networks')]
        #[ArrayOf(NetworkAttachmentConfig::class)]
        public array|Undefined $networks = Undefined::Value,
        #[SerializedName('EndpointSpec')]
        public EndpointSpec|Undefined $endpointSpec = Undefined::Value,
    ) {}
}
