<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_51\Image\Responses;

use Misaf\DockerEngine\Serialization\Undefined;
use Symfony\Component\Serializer\Attribute\SerializedName;

/** Delete builder cache */
final readonly class BuildPruneResponse
{
    /**
     * @param list<string>|Undefined $cachesDeleted
     */
    public function __construct(
        #[SerializedName('CachesDeleted')]
        public array|Undefined $cachesDeleted = Undefined::Value,
        #[SerializedName('SpaceReclaimed')]
        public int|Undefined $spaceReclaimed = Undefined::Value,
    ) {}
}
