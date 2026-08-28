<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_55\Swarm\Responses;

use Misaf\DockerEngine\Serialization\Undefined;
use Symfony\Component\Serializer\Attribute\SerializedName;

/** Get the unlock key */
final readonly class SwarmUnlockkeyResponse
{
    public function __construct(
        #[SerializedName('UnlockKey')]
        public string|Undefined $unlockKey = Undefined::Value,
    ) {}
}
