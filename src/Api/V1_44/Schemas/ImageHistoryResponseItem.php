<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_44\Schemas;

use Symfony\Component\Serializer\Attribute\SerializedName;

/** individual image layer information in response to ImageHistory operation */
readonly class ImageHistoryResponseItem
{
    /**
     * @param list<string> $tags
     */
    public function __construct(
        #[SerializedName('Id')]
        public string $id,
        #[SerializedName('Created')]
        public int $created,
        #[SerializedName('CreatedBy')]
        public string $createdBy,
        #[SerializedName('Tags')]
        public array $tags,
        #[SerializedName('Size')]
        public int $size,
        #[SerializedName('Comment')]
        public string $comment,
    ) {}
}
