<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_41\Image\Responses;

final readonly class ImageHistoryResponse
{
    /** @param list<\Misaf\DockerEngine\Api\V1_41\Schemas\ImageHistoryResponseItem> $items */
    public function __construct(
        #[\Misaf\DockerEngine\Serialization\ArrayOf(\Misaf\DockerEngine\Api\V1_41\Schemas\ImageHistoryResponseItem::class)]
        public array $items,
    ) {}
}
