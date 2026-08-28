<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_46\Exec\Responses;

use Misaf\DockerEngine\Serialization\Undefined;
use Symfony\Component\Serializer\Attribute\SerializedName;

/** Inspect an exec instance */
final readonly class ExecInspectResponse
{
    /**
     * @param \Misaf\DockerEngine\Api\V1_46\Schemas\ProcessConfig|Undefined $processConfig
     */
    public function __construct(
        #[SerializedName('CanRemove')]
        public bool|Undefined $canRemove = Undefined::Value,
        #[SerializedName('DetachKeys')]
        public string|Undefined $detachKeys = Undefined::Value,
        #[SerializedName('ID')]
        public string|Undefined $id = Undefined::Value,
        #[SerializedName('Running')]
        public bool|Undefined $running = Undefined::Value,
        #[SerializedName('ExitCode')]
        public int|Undefined $exitCode = Undefined::Value,
        #[SerializedName('ProcessConfig')]
        public \Misaf\DockerEngine\Api\V1_46\Schemas\ProcessConfig|Undefined $processConfig = Undefined::Value,
        #[SerializedName('OpenStdin')]
        public bool|Undefined $openStdin = Undefined::Value,
        #[SerializedName('OpenStderr')]
        public bool|Undefined $openStderr = Undefined::Value,
        #[SerializedName('OpenStdout')]
        public bool|Undefined $openStdout = Undefined::Value,
        #[SerializedName('ContainerID')]
        public string|Undefined $containerId = Undefined::Value,
        #[SerializedName('Pid')]
        public int|Undefined $pid = Undefined::Value,
    ) {}
}
