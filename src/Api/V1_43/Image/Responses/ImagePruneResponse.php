<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_43\Image\Responses;

use Misaf\DockerEngine\Serialization\ArrayOf;
use Misaf\DockerEngine\Serialization\Undefined;
use Symfony\Component\Serializer\Attribute\SerializedName;

/** Delete unused images */
final readonly class ImagePruneResponse
{
    /**
     * @param list<\Misaf\DockerEngine\Api\V1_43\Schemas\ImageDeleteResponseItem>|Undefined $imagesDeleted
     */
    public function __construct(
        #[SerializedName('ImagesDeleted')]
        #[ArrayOf(\Misaf\DockerEngine\Api\V1_43\Schemas\ImageDeleteResponseItem::class)]
        public array|Undefined $imagesDeleted = Undefined::Value,
        #[SerializedName('SpaceReclaimed')]
        public int|Undefined $spaceReclaimed = Undefined::Value,
    ) {}
}
