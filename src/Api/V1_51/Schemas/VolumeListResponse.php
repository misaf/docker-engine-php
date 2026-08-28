<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_51\Schemas;

use Misaf\DockerEngine\Serialization\ArrayOf;
use Misaf\DockerEngine\Serialization\Undefined;
use Symfony\Component\Serializer\Attribute\SerializedName;

/** Volume list response */
readonly class VolumeListResponse
{
    /**
     * @param list<Volume>|Undefined $volumes
     * @param list<string>|Undefined $warnings
     */
    public function __construct(
        #[SerializedName('Volumes')]
        #[ArrayOf(Volume::class)]
        public array|Undefined $volumes = Undefined::Value,
        #[SerializedName('Warnings')]
        public array|Undefined $warnings = Undefined::Value,
    ) {}
}
