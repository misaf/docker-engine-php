<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_42\Schemas;

use Misaf\DockerEngine\Serialization\Undefined;
use Symfony\Component\Serializer\Attribute\SerializedName;

/** User modifiable swarm configuration. */
readonly class SwarmSpec
{
    /**
     * @param array<string, mixed>|Undefined $labels
     * @param array<string, mixed>|Undefined $orchestration
     * @param array<string, mixed>|Undefined $raft
     * @param array<string, mixed>|Undefined $dispatcher
     * @param array<string, mixed>|Undefined $caConfig
     * @param array<string, mixed>|Undefined $encryptionConfig
     * @param array<string, mixed>|Undefined $taskDefaults
     */
    public function __construct(
        #[SerializedName('Name')]
        public string|Undefined $name = Undefined::Value,
        #[SerializedName('Labels')]
        public array|Undefined $labels = Undefined::Value,
        #[SerializedName('Orchestration')]
        public array|Undefined|null $orchestration = Undefined::Value,
        #[SerializedName('Raft')]
        public array|Undefined $raft = Undefined::Value,
        #[SerializedName('Dispatcher')]
        public array|Undefined|null $dispatcher = Undefined::Value,
        #[SerializedName('CAConfig')]
        public array|Undefined|null $caConfig = Undefined::Value,
        #[SerializedName('EncryptionConfig')]
        public array|Undefined $encryptionConfig = Undefined::Value,
        #[SerializedName('TaskDefaults')]
        public array|Undefined $taskDefaults = Undefined::Value,
    ) {}
}
