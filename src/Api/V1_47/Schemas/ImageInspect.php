<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_47\Schemas;

use Misaf\DockerEngine\Serialization\Undefined;
use Symfony\Component\Serializer\Attribute\SerializedName;

/** Information about an image in the local image cache. */
readonly class ImageInspect
{
    /**
     * @param list<string>|Undefined $repoTags
     * @param list<string>|Undefined $repoDigests
     * @param ImageConfig|Undefined $config
     * @param DriverData|Undefined $graphDriver
     * @param array<string, mixed>|Undefined $rootFs
     * @param array<string, mixed>|Undefined $metadata
     */
    public function __construct(
        #[SerializedName('Id')]
        public string|Undefined $id = Undefined::Value,
        #[SerializedName('RepoTags')]
        public array|Undefined $repoTags = Undefined::Value,
        #[SerializedName('RepoDigests')]
        public array|Undefined $repoDigests = Undefined::Value,
        #[SerializedName('Parent')]
        public string|Undefined $parent = Undefined::Value,
        #[SerializedName('Comment')]
        public string|Undefined $comment = Undefined::Value,
        #[SerializedName('Created')]
        public string|Undefined|null $created = Undefined::Value,
        #[SerializedName('DockerVersion')]
        public string|Undefined $dockerVersion = Undefined::Value,
        #[SerializedName('Author')]
        public string|Undefined $author = Undefined::Value,
        #[SerializedName('Config')]
        public ImageConfig|Undefined $config = Undefined::Value,
        #[SerializedName('Architecture')]
        public string|Undefined $architecture = Undefined::Value,
        #[SerializedName('Variant')]
        public string|Undefined|null $variant = Undefined::Value,
        #[SerializedName('Os')]
        public string|Undefined $os = Undefined::Value,
        #[SerializedName('OsVersion')]
        public string|Undefined|null $osVersion = Undefined::Value,
        #[SerializedName('Size')]
        public int|Undefined $size = Undefined::Value,
        #[SerializedName('GraphDriver')]
        public DriverData|Undefined $graphDriver = Undefined::Value,
        #[SerializedName('RootFS')]
        public array|Undefined $rootFs = Undefined::Value,
        #[SerializedName('Metadata')]
        public array|Undefined $metadata = Undefined::Value,
    ) {}
}
