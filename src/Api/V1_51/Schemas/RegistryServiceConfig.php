<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_51\Schemas;

use Misaf\DockerEngine\Serialization\Undefined;
use Symfony\Component\Serializer\Attribute\SerializedName;

/** RegistryServiceConfig stores daemon registry services configuration. */
readonly class RegistryServiceConfig
{
    /**
     * @param list<string>|Undefined $insecureRegistryCidRs
     * @param array<string, mixed>|Undefined $indexConfigs
     * @param list<string>|Undefined $mirrors
     */
    public function __construct(
        #[SerializedName('InsecureRegistryCIDRs')]
        public array|Undefined $insecureRegistryCidRs = Undefined::Value,
        #[SerializedName('IndexConfigs')]
        public array|Undefined $indexConfigs = Undefined::Value,
        #[SerializedName('Mirrors')]
        public array|Undefined $mirrors = Undefined::Value,
    ) {}
}
