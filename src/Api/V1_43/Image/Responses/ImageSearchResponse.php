<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_43\Image\Responses;

final readonly class ImageSearchResponse
{
    /** @param list<array<string, mixed>> $items */
    public function __construct(
        public array $items,
    ) {}
}
