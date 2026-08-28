<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_45\Schemas;

use Misaf\DockerEngine\Serialization\Undefined;
use Symfony\Component\Serializer\Attribute\SerializedName;

/** ManagerStatus represents the status of a manager. */
readonly class ManagerStatus
{
    /**
     * @param Reachability|Undefined $reachability
     */
    public function __construct(
        #[SerializedName('Leader')]
        public bool|Undefined $leader = Undefined::Value,
        #[SerializedName('Reachability')]
        public Reachability|Undefined $reachability = Undefined::Value,
        #[SerializedName('Addr')]
        public string|Undefined $addr = Undefined::Value,
    ) {}
}
