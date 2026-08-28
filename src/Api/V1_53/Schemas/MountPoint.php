<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_53\Schemas;

use Misaf\DockerEngine\Serialization\Undefined;
use Symfony\Component\Serializer\Attribute\SerializedName;

/** MountPoint represents a mount point configuration inside the container. */
readonly class MountPoint
{
    /**
     * @param MountType|Undefined $type
     */
    public function __construct(
        #[SerializedName('Type')]
        public MountType|Undefined $type = Undefined::Value,
        #[SerializedName('Name')]
        public string|Undefined $name = Undefined::Value,
        #[SerializedName('Source')]
        public string|Undefined $source = Undefined::Value,
        #[SerializedName('Destination')]
        public string|Undefined $destination = Undefined::Value,
        #[SerializedName('Driver')]
        public string|Undefined $driver = Undefined::Value,
        #[SerializedName('Mode')]
        public string|Undefined $mode = Undefined::Value,
        #[SerializedName('RW')]
        public bool|Undefined $rw = Undefined::Value,
        #[SerializedName('Propagation')]
        public string|Undefined $propagation = Undefined::Value,
    ) {}
}
