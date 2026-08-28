<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_53\Schemas;

use Misaf\DockerEngine\Serialization\Undefined;
use Symfony\Component\Serializer\Attribute\SerializedName;

/** Actor describes something that generates events, like a container, network, */
readonly class EventActor
{
    /**
     * @param array<string, mixed>|Undefined $attributes
     */
    public function __construct(
        #[SerializedName('ID')]
        public string|Undefined $id = Undefined::Value,
        #[SerializedName('Attributes')]
        public array|Undefined $attributes = Undefined::Value,
    ) {}
}
