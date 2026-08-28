<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_52\Schemas;

use Misaf\DockerEngine\Serialization\Undefined;
use Symfony\Component\Serializer\Attribute\SerializedName;

/** StorageStats is the disk I/O stats for read/write on Windows. */
readonly class ContainerStorageStats
{
    public function __construct(
        #[SerializedName('read_count_normalized')]
        public int|Undefined|null $readCountNormalized = Undefined::Value,
        #[SerializedName('read_size_bytes')]
        public int|Undefined|null $readSizeBytes = Undefined::Value,
        #[SerializedName('write_count_normalized')]
        public int|Undefined|null $writeCountNormalized = Undefined::Value,
        #[SerializedName('write_size_bytes')]
        public int|Undefined|null $writeSizeBytes = Undefined::Value,
    ) {}
}
