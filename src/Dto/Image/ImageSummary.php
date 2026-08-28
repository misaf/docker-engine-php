<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Dto\Image;

final readonly class ImageSummary
{
    /**
     * @param list<string> $repoTags
     * @param list<string> $repoDigests
     */
    public function __construct(
        public string $id,
        public array $repoTags,
        public array $repoDigests,
        public int $created,
        public int $size,
    ) {}
}
