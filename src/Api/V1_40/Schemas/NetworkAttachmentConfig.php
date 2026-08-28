<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_40\Schemas;

use Misaf\DockerEngine\Serialization\Undefined;
use Symfony\Component\Serializer\Attribute\SerializedName;

/** Specifies how a service should be attached to a particular network. */
readonly class NetworkAttachmentConfig
{
    /**
     * @param list<string>|Undefined $aliases
     * @param array<string, mixed>|Undefined $driverOpts
     */
    public function __construct(
        #[SerializedName('Target')]
        public string|Undefined $target = Undefined::Value,
        #[SerializedName('Aliases')]
        public array|Undefined $aliases = Undefined::Value,
        #[SerializedName('DriverOpts')]
        public array|Undefined $driverOpts = Undefined::Value,
    ) {}
}
