<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_49\Schemas;

use Misaf\DockerEngine\Serialization\ArrayOf;
use Symfony\Component\Serializer\Attribute\SerializedName;

/** Describes the result obtained from contacting the registry to retrieve */
readonly class DistributionInspect
{
    /**
     * @param OCIDescriptor $descriptor
     * @param list<OCIPlatform> $platforms
     */
    public function __construct(
        #[SerializedName('Descriptor')]
        public OCIDescriptor $descriptor,
        #[SerializedName('Platforms')]
        #[ArrayOf(OCIPlatform::class)]
        public array $platforms,
    ) {}
}
