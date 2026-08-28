<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_50\Schemas;

use Misaf\DockerEngine\Serialization\Undefined;
use Symfony\Component\Serializer\Attribute\SerializedName;

/** JoinTokens contains the tokens workers and managers need to join the swarm. */
readonly class JoinTokens
{
    public function __construct(
        #[SerializedName('Worker')]
        public string|Undefined $worker = Undefined::Value,
        #[SerializedName('Manager')]
        public string|Undefined $manager = Undefined::Value,
    ) {}
}
