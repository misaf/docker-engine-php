<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_43\Network\Responses;

use Misaf\DockerEngine\Serialization\Undefined;
use Symfony\Component\Serializer\Attribute\SerializedName;

/** Delete unused networks */
final readonly class NetworkPruneResponse
{
    /**
     * @param list<string>|Undefined $networksDeleted
     */
    public function __construct(
        #[SerializedName('NetworksDeleted')]
        public array|Undefined $networksDeleted = Undefined::Value,
    ) {}
}
