<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_42\Schemas;

use Misaf\DockerEngine\Serialization\Undefined;
use Symfony\Component\Serializer\Attribute\SerializedName;

readonly class Node
{
    /**
     * @param ObjectVersion|Undefined $version
     * @param NodeSpec|Undefined $spec
     * @param NodeDescription|Undefined $description
     * @param NodeStatus|Undefined $status
     * @param ManagerStatus|Undefined $managerStatus
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
        public NodeSpec|Undefined $spec = Undefined::Value,
        #[SerializedName('Description')]
        public NodeDescription|Undefined $description = Undefined::Value,
        #[SerializedName('Status')]
        public NodeStatus|Undefined $status = Undefined::Value,
        #[SerializedName('ManagerStatus')]
        public ManagerStatus|Undefined $managerStatus = Undefined::Value,
    ) {}
}
