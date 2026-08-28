<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_47\Schemas;

use Misaf\DockerEngine\Serialization\Undefined;
use Symfony\Component\Serializer\Attribute\SerializedName;

/** Describes the platform which the image in the manifest runs on, as defined */
readonly class OCIPlatform
{
    /**
     * @param list<string>|Undefined $osFeatures
     */
    public function __construct(
        #[SerializedName('architecture')]
        public string|Undefined $architecture = Undefined::Value,
        #[SerializedName('os')]
        public string|Undefined $os = Undefined::Value,
        #[SerializedName('os.version')]
        public string|Undefined $osVersion = Undefined::Value,
        #[SerializedName('os.features')]
        public array|Undefined $osFeatures = Undefined::Value,
        #[SerializedName('variant')]
        public string|Undefined $variant = Undefined::Value,
    ) {}
}
