<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_47\Image\Responses;

final readonly class ImageHistoryResponse
{
    /** @param list<\Misaf\DockerEngine\Api\V1_47\Schemas\ImageHistoryResponseItem> $items */
    public function __construct(
        #[\Misaf\DockerEngine\Serialization\ArrayOf(\Misaf\DockerEngine\Api\V1_47\Schemas\ImageHistoryResponseItem::class)]
        public array $items,
    ) {}
}
