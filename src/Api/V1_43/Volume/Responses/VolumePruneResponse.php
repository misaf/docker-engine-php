<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_43\Volume\Responses;

use Misaf\DockerEngine\Serialization\Undefined;
use Symfony\Component\Serializer\Attribute\SerializedName;

/** Delete unused volumes */
final readonly class VolumePruneResponse
{
    /**
     * @param list<string>|Undefined $volumesDeleted
     */
    public function __construct(
        #[SerializedName('VolumesDeleted')]
        public array|Undefined $volumesDeleted = Undefined::Value,
        #[SerializedName('SpaceReclaimed')]
        public int|Undefined $spaceReclaimed = Undefined::Value,
    ) {}
}
