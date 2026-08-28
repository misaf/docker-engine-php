<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_54\Schemas;

use Misaf\DockerEngine\Serialization\Undefined;
use Symfony\Component\Serializer\Attribute\SerializedName;

/** Information about the daemon's firewalling configuration. */
readonly class FirewallInfo
{
    /**
     * @param list<list<string>>|Undefined $info
     */
    public function __construct(
        #[SerializedName('Driver')]
        public string|Undefined $driver = Undefined::Value,
        #[SerializedName('Info')]
        public array|Undefined $info = Undefined::Value,
    ) {}
}
