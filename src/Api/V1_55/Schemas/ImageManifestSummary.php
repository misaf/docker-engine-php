<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_55\Schemas;

use Misaf\DockerEngine\Serialization\Undefined;
use Symfony\Component\Serializer\Attribute\SerializedName;

/** ImageManifestSummary represents a summary of an image manifest. */
readonly class ImageManifestSummary
{
    /**
     * @param OCIDescriptor $descriptor
     * @param array<string, mixed> $size
     * @param array<string, mixed>|Undefined $imageData
     * @param array<string, mixed>|Undefined $attestationData
     */
    public function __construct(
        #[SerializedName('ID')]
        public string $id,
        #[SerializedName('Descriptor')]
        public OCIDescriptor $descriptor,
        #[SerializedName('Available')]
        public bool $available,
        #[SerializedName('Size')]
        public array $size,
        #[SerializedName('Kind')]
        public string $kind,
        #[SerializedName('ImageData')]
        public array|Undefined|null $imageData = Undefined::Value,
        #[SerializedName('AttestationData')]
        public array|Undefined|null $attestationData = Undefined::Value,
    ) {}
}
