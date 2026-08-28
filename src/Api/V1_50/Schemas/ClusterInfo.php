<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_50\Schemas;

use Misaf\DockerEngine\Serialization\Undefined;
use Symfony\Component\Serializer\Attribute\SerializedName;

/** ClusterInfo represents information about the swarm as is returned by the */
readonly class ClusterInfo
{
    /**
     * @param ObjectVersion|Undefined $version
     * @param SwarmSpec|Undefined $spec
     * @param TLSInfo|Undefined $tlsInfo
     * @param list<string>|Undefined $defaultAddrPool
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
        public SwarmSpec|Undefined $spec = Undefined::Value,
        #[SerializedName('TLSInfo')]
        public TLSInfo|Undefined $tlsInfo = Undefined::Value,
        #[SerializedName('RootRotationInProgress')]
        public bool|Undefined $rootRotationInProgress = Undefined::Value,
        #[SerializedName('DataPathPort')]
        public int|Undefined $dataPathPort = Undefined::Value,
        #[SerializedName('DefaultAddrPool')]
        public array|Undefined $defaultAddrPool = Undefined::Value,
        #[SerializedName('SubnetSize')]
        public int|Undefined $subnetSize = Undefined::Value,
    ) {}
}
