<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_52\Image\Responses;

final readonly class ImageDeleteResponse
{
    /** @param list<\Misaf\DockerEngine\Api\V1_52\Schemas\ImageDeleteResponseItem> $items */
    public function __construct(
        #[\Misaf\DockerEngine\Serialization\ArrayOf(\Misaf\DockerEngine\Api\V1_52\Schemas\ImageDeleteResponseItem::class)]
        public array $items,
    ) {}
}
