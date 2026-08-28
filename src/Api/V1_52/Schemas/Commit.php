<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_52\Schemas;

use Misaf\DockerEngine\Serialization\Undefined;
use Symfony\Component\Serializer\Attribute\SerializedName;

/** Commit holds the Git-commit (SHA1) that a binary was built from, as */
readonly class Commit
{
    public function __construct(
        #[SerializedName('ID')]
        public string|Undefined $id = Undefined::Value,
    ) {}
}
