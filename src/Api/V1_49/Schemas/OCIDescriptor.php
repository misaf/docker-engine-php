<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_49\Schemas;

use Misaf\DockerEngine\Serialization\Undefined;
use Symfony\Component\Serializer\Attribute\SerializedName;

/** A descriptor struct containing digest, media type, and size, as defined in */
readonly class OCIDescriptor
{
    /**
     * @param list<string>|Undefined $urls
     * @param array<string, mixed>|Undefined $annotations
     * @param OCIPlatform|Undefined $platform
     */
    public function __construct(
        #[SerializedName('mediaType')]
        public string|Undefined $mediaType = Undefined::Value,
        #[SerializedName('digest')]
        public string|Undefined $digest = Undefined::Value,
        #[SerializedName('size')]
        public int|Undefined $size = Undefined::Value,
        #[SerializedName('urls')]
        public array|Undefined|null $urls = Undefined::Value,
        #[SerializedName('annotations')]
        public array|Undefined|null $annotations = Undefined::Value,
        #[SerializedName('data')]
        public string|Undefined|null $data = Undefined::Value,
        #[SerializedName('platform')]
        public OCIPlatform|Undefined $platform = Undefined::Value,
        #[SerializedName('artifactType')]
        public string|Undefined|null $artifactType = Undefined::Value,
    ) {}
}
