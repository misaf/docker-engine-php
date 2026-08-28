<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_53\Schemas;

use Misaf\DockerEngine\Serialization\ArrayOf;
use Misaf\DockerEngine\Serialization\Undefined;
use Symfony\Component\Serializer\Attribute\SerializedName;

readonly class Task
{
    /**
     * @param ObjectVersion|Undefined $version
     * @param array<string, mixed>|Undefined $labels
     * @param TaskSpec|Undefined $spec
     * @param array<array-key, mixed>|Undefined $assignedGenericResources
     * @param TaskStatus|Undefined $status
     * @param TaskState|Undefined $desiredState
     * @param ObjectVersion|Undefined $jobIteration
     * @param list<NetworkAttachment>|Undefined $networksAttachments
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
        #[SerializedName('Name')]
        public string|Undefined $name = Undefined::Value,
        #[SerializedName('Labels')]
        public array|Undefined $labels = Undefined::Value,
        #[SerializedName('Spec')]
        public TaskSpec|Undefined $spec = Undefined::Value,
        #[SerializedName('ServiceID')]
        public string|Undefined $serviceId = Undefined::Value,
        #[SerializedName('Slot')]
        public int|Undefined $slot = Undefined::Value,
        #[SerializedName('NodeID')]
        public string|Undefined $nodeId = Undefined::Value,
        #[SerializedName('AssignedGenericResources')]
        public array|Undefined $assignedGenericResources = Undefined::Value,
        #[SerializedName('Status')]
        public TaskStatus|Undefined $status = Undefined::Value,
        #[SerializedName('DesiredState')]
        public TaskState|Undefined $desiredState = Undefined::Value,
        #[SerializedName('JobIteration')]
        public ObjectVersion|Undefined $jobIteration = Undefined::Value,
        #[SerializedName('NetworksAttachments')]
        #[ArrayOf(NetworkAttachment::class)]
        public array|Undefined $networksAttachments = Undefined::Value,
    ) {}
}
