<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_55\Schemas;

use Misaf\DockerEngine\Serialization\ArrayOf;
use Misaf\DockerEngine\Serialization\Undefined;
use Symfony\Component\Serializer\Attribute\SerializedName;

readonly class ImageSummary
{
    /**
     * @param list<string> $repoTags
     * @param list<string> $repoDigests
     * @param array<string, mixed> $labels
     * @param list<ImageManifestSummary>|Undefined $manifests
     * @param OCIDescriptor|Undefined $descriptor
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
        #[SerializedName('Manifests')]
        #[ArrayOf(ImageManifestSummary::class)]
        public array|Undefined $manifests = Undefined::Value,
        #[SerializedName('Descriptor')]
        public OCIDescriptor|Undefined|null $descriptor = Undefined::Value,
    ) {}
}
