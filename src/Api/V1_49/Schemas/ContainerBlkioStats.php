<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_49\Schemas;

use Misaf\DockerEngine\Serialization\ArrayOf;
use Misaf\DockerEngine\Serialization\Undefined;
use Symfony\Component\Serializer\Attribute\SerializedName;

/** BlkioStats stores all IO service stats for data read and write. */
readonly class ContainerBlkioStats
{
    /**
     * @param list<ContainerBlkioStatEntry>|Undefined $ioServiceBytesRecursive
     * @param list<ContainerBlkioStatEntry>|Undefined $ioServicedRecursive
     * @param list<ContainerBlkioStatEntry>|Undefined $ioQueueRecursive
     * @param list<ContainerBlkioStatEntry>|Undefined $ioServiceTimeRecursive
     * @param list<ContainerBlkioStatEntry>|Undefined $ioWaitTimeRecursive
     * @param list<ContainerBlkioStatEntry>|Undefined $ioMergedRecursive
     * @param list<ContainerBlkioStatEntry>|Undefined $ioTimeRecursive
     * @param list<ContainerBlkioStatEntry>|Undefined $sectorsRecursive
     */
    public function __construct(
        #[SerializedName('io_service_bytes_recursive')]
        #[ArrayOf(ContainerBlkioStatEntry::class)]
        public array|Undefined $ioServiceBytesRecursive = Undefined::Value,
        #[SerializedName('io_serviced_recursive')]
        #[ArrayOf(ContainerBlkioStatEntry::class)]
        public array|Undefined|null $ioServicedRecursive = Undefined::Value,
        #[SerializedName('io_queue_recursive')]
        #[ArrayOf(ContainerBlkioStatEntry::class)]
        public array|Undefined|null $ioQueueRecursive = Undefined::Value,
        #[SerializedName('io_service_time_recursive')]
        #[ArrayOf(ContainerBlkioStatEntry::class)]
        public array|Undefined|null $ioServiceTimeRecursive = Undefined::Value,
        #[SerializedName('io_wait_time_recursive')]
        #[ArrayOf(ContainerBlkioStatEntry::class)]
        public array|Undefined|null $ioWaitTimeRecursive = Undefined::Value,
        #[SerializedName('io_merged_recursive')]
        #[ArrayOf(ContainerBlkioStatEntry::class)]
        public array|Undefined|null $ioMergedRecursive = Undefined::Value,
        #[SerializedName('io_time_recursive')]
        #[ArrayOf(ContainerBlkioStatEntry::class)]
        public array|Undefined|null $ioTimeRecursive = Undefined::Value,
        #[SerializedName('sectors_recursive')]
        #[ArrayOf(ContainerBlkioStatEntry::class)]
        public array|Undefined|null $sectorsRecursive = Undefined::Value,
    ) {}
}
