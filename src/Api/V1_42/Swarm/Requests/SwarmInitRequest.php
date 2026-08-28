<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_42\Swarm\Requests;

use Misaf\DockerEngine\Generated\GeneratedRequest;
use Misaf\DockerEngine\Generated\RequestParameter;

final readonly class SwarmInitRequest extends GeneratedRequest
{
    /**
     * @param array<string, mixed> $body
     */
    public function __construct(
        #[RequestParameter('body', 'body', false)]
        public array $body,
    ) {}
}
