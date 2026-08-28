<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_53\Schemas;

use Misaf\DockerEngine\Serialization\Undefined;
use Symfony\Component\Serializer\Attribute\SerializedName;

/** EventMessage represents the information an event contains. */
readonly class EventMessage
{
    /**
     * @param EventActor|Undefined $actor
     */
    public function __construct(
        #[SerializedName('Type')]
        public string|Undefined $type = Undefined::Value,
        #[SerializedName('Action')]
        public string|Undefined $action = Undefined::Value,
        #[SerializedName('Actor')]
        public EventActor|Undefined $actor = Undefined::Value,
        #[SerializedName('scope')]
        public string|Undefined $scope = Undefined::Value,
        #[SerializedName('time')]
        public int|Undefined $time = Undefined::Value,
        #[SerializedName('timeNano')]
        public int|Undefined $timeNano = Undefined::Value,
    ) {}
}
