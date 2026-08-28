<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_55\Schemas;

use Misaf\DockerEngine\Serialization\ArrayOf;
use Misaf\DockerEngine\Serialization\Undefined;
use Symfony\Component\Serializer\Attribute\SerializedName;

/** Identity holds information about the identity and origin of the image. */
readonly class Identity
{
    /**
     * @param list<SignatureIdentity>|Undefined $signature
     * @param list<PullIdentity>|Undefined $pull
     * @param list<BuildIdentity>|Undefined $build
     */
    public function __construct(
        #[SerializedName('Signature')]
        #[ArrayOf(SignatureIdentity::class)]
        public array|Undefined $signature = Undefined::Value,
        #[SerializedName('Pull')]
        #[ArrayOf(PullIdentity::class)]
        public array|Undefined $pull = Undefined::Value,
        #[SerializedName('Build')]
        #[ArrayOf(BuildIdentity::class)]
        public array|Undefined $build = Undefined::Value,
    ) {}
}
