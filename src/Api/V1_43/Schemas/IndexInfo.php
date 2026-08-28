<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_43\Schemas;

use Misaf\DockerEngine\Serialization\Undefined;
use Symfony\Component\Serializer\Attribute\SerializedName;

/** IndexInfo contains information about a registry. */
readonly class IndexInfo
{
    /**
     * @param list<string>|Undefined $mirrors
     */
    public function __construct(
        #[SerializedName('Name')]
        public string|Undefined $name = Undefined::Value,
        #[SerializedName('Mirrors')]
        public array|Undefined $mirrors = Undefined::Value,
        #[SerializedName('Secure')]
        public bool|Undefined $secure = Undefined::Value,
        #[SerializedName('Official')]
        public bool|Undefined $official = Undefined::Value,
    ) {}
}
