<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_55\Image\Responses;

final readonly class ImageListResponse
{
    /** @param list<\Misaf\DockerEngine\Api\V1_55\Schemas\ImageSummary> $items */
    public function __construct(
        #[\Misaf\DockerEngine\Serialization\ArrayOf(\Misaf\DockerEngine\Api\V1_55\Schemas\ImageSummary::class)]
        public array $items,
    ) {}
}
