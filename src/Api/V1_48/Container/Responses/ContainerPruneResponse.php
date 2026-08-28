<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_48\Container\Responses;

use Misaf\DockerEngine\Serialization\Undefined;
use Symfony\Component\Serializer\Attribute\SerializedName;

/** Delete stopped containers */
final readonly class ContainerPruneResponse
{
    /**
     * @param list<string>|Undefined $containersDeleted
     */
    public function __construct(
        #[SerializedName('ContainersDeleted')]
        public array|Undefined $containersDeleted = Undefined::Value,
        #[SerializedName('SpaceReclaimed')]
        public int|Undefined $spaceReclaimed = Undefined::Value,
    ) {}
}
