<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_49\Swarm\Requests;

use Misaf\DockerEngine\Generated\GeneratedRequest;
use Misaf\DockerEngine\Generated\RequestParameter;
use Misaf\DockerEngine\Serialization\Undefined;

final readonly class SwarmLeaveRequest extends GeneratedRequest
{
    public function __construct(
        #[RequestParameter('force', 'query', false)]
        public bool|Undefined $force = Undefined::Value,
    ) {}
}
