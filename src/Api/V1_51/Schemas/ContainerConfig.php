<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_51\Schemas;

use Misaf\DockerEngine\Serialization\Undefined;
use Symfony\Component\Serializer\Attribute\SerializedName;

/** Configuration for a container that is portable between hosts. */
readonly class ContainerConfig
{
    /**
     * @param array<string, mixed>|Undefined $exposedPorts
     * @param list<string>|Undefined $env
     * @param list<string>|Undefined $cmd
     * @param HealthConfig|Undefined $healthcheck
     * @param array<string, mixed>|Undefined $volumes
     * @param list<string>|Undefined $entrypoint
     * @param list<string>|Undefined $onBuild
     * @param array<string, mixed>|Undefined $labels
     * @param list<string>|Undefined $shell
     */
    public function __construct(
        #[SerializedName('Hostname')]
        public string|Undefined $hostname = Undefined::Value,
        #[SerializedName('Domainname')]
        public string|Undefined $domainname = Undefined::Value,
        #[SerializedName('User')]
        public string|Undefined $user = Undefined::Value,
        #[SerializedName('AttachStdin')]
        public bool|Undefined $attachStdin = Undefined::Value,
        #[SerializedName('AttachStdout')]
        public bool|Undefined $attachStdout = Undefined::Value,
        #[SerializedName('AttachStderr')]
        public bool|Undefined $attachStderr = Undefined::Value,
        #[SerializedName('ExposedPorts')]
        public array|Undefined|null $exposedPorts = Undefined::Value,
        #[SerializedName('Tty')]
        public bool|Undefined $tty = Undefined::Value,
        #[SerializedName('OpenStdin')]
        public bool|Undefined $openStdin = Undefined::Value,
        #[SerializedName('StdinOnce')]
        public bool|Undefined $stdinOnce = Undefined::Value,
        #[SerializedName('Env')]
        public array|Undefined $env = Undefined::Value,
        #[SerializedName('Cmd')]
        public array|Undefined $cmd = Undefined::Value,
        #[SerializedName('Healthcheck')]
        public HealthConfig|Undefined $healthcheck = Undefined::Value,
        #[SerializedName('ArgsEscaped')]
        public bool|Undefined|null $argsEscaped = Undefined::Value,
        #[SerializedName('Image')]
        public string|Undefined $image = Undefined::Value,
        #[SerializedName('Volumes')]
        public array|Undefined $volumes = Undefined::Value,
        #[SerializedName('WorkingDir')]
        public string|Undefined $workingDir = Undefined::Value,
        #[SerializedName('Entrypoint')]
        public array|Undefined $entrypoint = Undefined::Value,
        #[SerializedName('NetworkDisabled')]
        public bool|Undefined|null $networkDisabled = Undefined::Value,
        #[SerializedName('MacAddress')]
        public string|Undefined|null $macAddress = Undefined::Value,
        #[SerializedName('OnBuild')]
        public array|Undefined|null $onBuild = Undefined::Value,
        #[SerializedName('Labels')]
        public array|Undefined $labels = Undefined::Value,
        #[SerializedName('StopSignal')]
        public string|Undefined|null $stopSignal = Undefined::Value,
        #[SerializedName('StopTimeout')]
        public int|Undefined|null $stopTimeout = Undefined::Value,
        #[SerializedName('Shell')]
        public array|Undefined|null $shell = Undefined::Value,
    ) {}
}
