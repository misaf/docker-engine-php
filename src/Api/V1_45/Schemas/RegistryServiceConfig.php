<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_45\Schemas;

use Misaf\DockerEngine\Serialization\Undefined;
use Symfony\Component\Serializer\Attribute\SerializedName;

/** RegistryServiceConfig stores daemon registry services configuration. */
readonly class RegistryServiceConfig
{
    /**
     * @param list<string>|Undefined $allowNondistributableArtifactsCidRs
     * @param list<string>|Undefined $allowNondistributableArtifactsHostnames
     * @param list<string>|Undefined $insecureRegistryCidRs
     * @param array<string, mixed>|Undefined $indexConfigs
     * @param list<string>|Undefined $mirrors
     */
    public function __construct(
        #[SerializedName('AllowNondistributableArtifactsCIDRs')]
        public array|Undefined $allowNondistributableArtifactsCidRs = Undefined::Value,
        #[SerializedName('AllowNondistributableArtifactsHostnames')]
        public array|Undefined $allowNondistributableArtifactsHostnames = Undefined::Value,
        #[SerializedName('InsecureRegistryCIDRs')]
        public array|Undefined $insecureRegistryCidRs = Undefined::Value,
        #[SerializedName('IndexConfigs')]
        public array|Undefined $indexConfigs = Undefined::Value,
        #[SerializedName('Mirrors')]
        public array|Undefined $mirrors = Undefined::Value,
    ) {}
}
