<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_55\Schemas;

use Misaf\DockerEngine\Serialization\Undefined;
use Symfony\Component\Serializer\Attribute\SerializedName;

/** Response of Engine API: GET "/version" */
readonly class SystemVersion
{
    /**
     * @param array<string, mixed>|Undefined $platform
     * @param list<array<string, mixed>>|Undefined $components
     */
    public function __construct(
        #[SerializedName('Platform')]
        public array|Undefined $platform = Undefined::Value,
        #[SerializedName('Components')]
        public array|Undefined $components = Undefined::Value,
        #[SerializedName('Version')]
        public string|Undefined $version = Undefined::Value,
        #[SerializedName('ApiVersion')]
        public string|Undefined $apiVersion = Undefined::Value,
        #[SerializedName('MinAPIVersion')]
        public string|Undefined $minApiVersion = Undefined::Value,
        #[SerializedName('GitCommit')]
        public string|Undefined $gitCommit = Undefined::Value,
        #[SerializedName('GoVersion')]
        public string|Undefined $goVersion = Undefined::Value,
        #[SerializedName('Os')]
        public string|Undefined $os = Undefined::Value,
        #[SerializedName('Arch')]
        public string|Undefined $arch = Undefined::Value,
        #[SerializedName('KernelVersion')]
        public string|Undefined $kernelVersion = Undefined::Value,
        #[SerializedName('Experimental')]
        public bool|Undefined $experimental = Undefined::Value,
        #[SerializedName('BuildTime')]
        public string|Undefined $buildTime = Undefined::Value,
    ) {}
}
