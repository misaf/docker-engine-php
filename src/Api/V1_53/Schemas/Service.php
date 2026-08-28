<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_53\Schemas;

use Misaf\DockerEngine\Serialization\Undefined;
use Symfony\Component\Serializer\Attribute\SerializedName;

readonly class Service
{
    /**
     * @param ObjectVersion|Undefined $version
     * @param ServiceSpec|Undefined $spec
     * @param array<string, mixed>|Undefined $endpoint
     * @param array<string, mixed>|Undefined $updateStatus
     * @param array<string, mixed>|Undefined $serviceStatus
     * @param array<string, mixed>|Undefined $jobStatus
     */
    public function __construct(
        #[SerializedName('ID')]
        public string|Undefined $id = Undefined::Value,
        #[SerializedName('Version')]
        public ObjectVersion|Undefined $version = Undefined::Value,
        #[SerializedName('CreatedAt')]
        public string|Undefined $createdAt = Undefined::Value,
        #[SerializedName('UpdatedAt')]
        public string|Undefined $updatedAt = Undefined::Value,
        #[SerializedName('Spec')]
        public ServiceSpec|Undefined $spec = Undefined::Value,
        #[SerializedName('Endpoint')]
        public array|Undefined $endpoint = Undefined::Value,
        #[SerializedName('UpdateStatus')]
        public array|Undefined $updateStatus = Undefined::Value,
        #[SerializedName('ServiceStatus')]
        public array|Undefined $serviceStatus = Undefined::Value,
        #[SerializedName('JobStatus')]
        public array|Undefined $jobStatus = Undefined::Value,
    ) {}
}
