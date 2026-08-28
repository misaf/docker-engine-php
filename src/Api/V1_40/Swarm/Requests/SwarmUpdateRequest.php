<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_40\Swarm\Requests;

use Misaf\DockerEngine\Generated\GeneratedRequest;
use Misaf\DockerEngine\Generated\RequestParameter;
use Misaf\DockerEngine\Serialization\Undefined;

final readonly class SwarmUpdateRequest extends GeneratedRequest
{
    /**
     * @param \Misaf\DockerEngine\Api\V1_40\Schemas\SwarmSpec $body
     */
    public function __construct(
        #[RequestParameter('body', 'body', false)]
        public \Misaf\DockerEngine\Api\V1_40\Schemas\SwarmSpec $body,
        #[RequestParameter('version', 'query', false)]
        public int $version,
        #[RequestParameter('rotateWorkerToken', 'query', false)]
        public bool|Undefined $rotateWorkerToken = Undefined::Value,
        #[RequestParameter('rotateManagerToken', 'query', false)]
        public bool|Undefined $rotateManagerToken = Undefined::Value,
        #[RequestParameter('rotateManagerUnlockKey', 'query', false)]
        public bool|Undefined $rotateManagerUnlockKey = Undefined::Value,
    ) {}
}
