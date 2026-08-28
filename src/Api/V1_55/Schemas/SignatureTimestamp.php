<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_55\Schemas;

use Misaf\DockerEngine\Serialization\Undefined;
use Symfony\Component\Serializer\Attribute\SerializedName;

/** SignatureTimestamp contains information about a verified signed timestamp for an image signature. */
readonly class SignatureTimestamp
{
    /**
     * @param SignatureTimestampType|Undefined $type
     */
    public function __construct(
        #[SerializedName('Type')]
        public SignatureTimestampType|Undefined $type = Undefined::Value,
        #[SerializedName('URI')]
        public string|Undefined $uri = Undefined::Value,
        #[SerializedName('Timestamp')]
        public string|Undefined $timestamp = Undefined::Value,
    ) {}
}
