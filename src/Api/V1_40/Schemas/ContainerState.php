<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_40\Schemas;

use Misaf\DockerEngine\Serialization\Undefined;
use Symfony\Component\Serializer\Attribute\SerializedName;

/** ContainerState stores container's running state. It's part of ContainerJSONBase */
readonly class ContainerState
{
    /**
     * @param Health|Undefined $health
     */
    public function __construct(
        #[SerializedName('Status')]
        public string|Undefined $status = Undefined::Value,
        #[SerializedName('Running')]
        public bool|Undefined $running = Undefined::Value,
        #[SerializedName('Paused')]
        public bool|Undefined $paused = Undefined::Value,
        #[SerializedName('Restarting')]
        public bool|Undefined $restarting = Undefined::Value,
        #[SerializedName('OOMKilled')]
        public bool|Undefined $oomKilled = Undefined::Value,
        #[SerializedName('Dead')]
        public bool|Undefined $dead = Undefined::Value,
        #[SerializedName('Pid')]
        public int|Undefined $pid = Undefined::Value,
        #[SerializedName('ExitCode')]
        public int|Undefined $exitCode = Undefined::Value,
        #[SerializedName('Error')]
        public string|Undefined $error = Undefined::Value,
        #[SerializedName('StartedAt')]
        public string|Undefined $startedAt = Undefined::Value,
        #[SerializedName('FinishedAt')]
        public string|Undefined $finishedAt = Undefined::Value,
        #[SerializedName('Health')]
        public Health|Undefined $health = Undefined::Value,
    ) {}
}
