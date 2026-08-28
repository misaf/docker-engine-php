<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_44\Image\Responses;

final readonly class ImageDeleteResponse
{
    /** @param list<\Misaf\DockerEngine\Api\V1_44\Schemas\ImageDeleteResponseItem> $items */
    public function __construct(
        #[\Misaf\DockerEngine\Serialization\ArrayOf(\Misaf\DockerEngine\Api\V1_44\Schemas\ImageDeleteResponseItem::class)]
        public array $items,
    ) {}
}
