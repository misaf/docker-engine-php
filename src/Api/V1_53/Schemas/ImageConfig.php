<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_53\Schemas;

use Misaf\DockerEngine\Serialization\Undefined;
use Symfony\Component\Serializer\Attribute\SerializedName;

/** Configuration of the image. These fields are used as defaults */
readonly class ImageConfig
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
        #[SerializedName('User')]
        public string|Undefined $user = Undefined::Value,
        #[SerializedName('ExposedPorts')]
        public array|Undefined|null $exposedPorts = Undefined::Value,
        #[SerializedName('Env')]
        public array|Undefined $env = Undefined::Value,
        #[SerializedName('Cmd')]
        public array|Undefined $cmd = Undefined::Value,
        #[SerializedName('Healthcheck')]
        public HealthConfig|Undefined $healthcheck = Undefined::Value,
        #[SerializedName('ArgsEscaped')]
        public bool|Undefined|null $argsEscaped = Undefined::Value,
        #[SerializedName('Volumes')]
        public array|Undefined $volumes = Undefined::Value,
        #[SerializedName('WorkingDir')]
        public string|Undefined $workingDir = Undefined::Value,
        #[SerializedName('Entrypoint')]
        public array|Undefined $entrypoint = Undefined::Value,
        #[SerializedName('OnBuild')]
        public array|Undefined|null $onBuild = Undefined::Value,
        #[SerializedName('Labels')]
        public array|Undefined $labels = Undefined::Value,
        #[SerializedName('StopSignal')]
        public string|Undefined|null $stopSignal = Undefined::Value,
        #[SerializedName('Shell')]
        public array|Undefined|null $shell = Undefined::Value,
    ) {}
}
