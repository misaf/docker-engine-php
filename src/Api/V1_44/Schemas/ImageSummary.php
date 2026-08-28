<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_44\Schemas;

use Symfony\Component\Serializer\Attribute\SerializedName;

readonly class ImageSummary
{
    /**
     * @param list<string> $repoTags
     * @param list<string> $repoDigests
     * @param array<string, mixed> $labels
     */
    public function __construct(
        #[SerializedName('Id')]
        public string $id,
        #[SerializedName('ParentId')]
        public string $parentId,
        #[SerializedName('RepoTags')]
        public array $repoTags,
        #[SerializedName('RepoDigests')]
        public array $repoDigests,
        #[SerializedName('Created')]
        public int $created,
        #[SerializedName('Size')]
        public int $size,
        #[SerializedName('SharedSize')]
        public int $sharedSize,
        #[SerializedName('Labels')]
        public array $labels,
        #[SerializedName('Containers')]
        public int $containers,
    ) {}
}
