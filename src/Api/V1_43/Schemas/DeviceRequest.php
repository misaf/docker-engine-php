<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_43\Schemas;

use Misaf\DockerEngine\Serialization\Undefined;
use Symfony\Component\Serializer\Attribute\SerializedName;

/** A request for devices to be sent to device drivers */
readonly class DeviceRequest
{
    /**
     * @param list<string>|Undefined $deviceIDs
     * @param list<list<string>>|Undefined $capabilities
     * @param array<string, mixed>|Undefined $options
     */
    public function __construct(
        #[SerializedName('Driver')]
        public string|Undefined $driver = Undefined::Value,
        #[SerializedName('Count')]
        public int|Undefined $count = Undefined::Value,
        #[SerializedName('DeviceIDs')]
        public array|Undefined $deviceIDs = Undefined::Value,
        #[SerializedName('Capabilities')]
        public array|Undefined $capabilities = Undefined::Value,
        #[SerializedName('Options')]
        public array|Undefined $options = Undefined::Value,
    ) {}
}
