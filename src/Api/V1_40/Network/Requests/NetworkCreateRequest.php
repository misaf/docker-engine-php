<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_40\Network\Requests;

use Misaf\DockerEngine\Generated\GeneratedRequest;
use Misaf\DockerEngine\Generated\RequestParameter;

final readonly class NetworkCreateRequest extends GeneratedRequest
{
    /**
     * @param array<string, mixed> $networkConfig
     */
    public function __construct(
        #[RequestParameter('networkConfig', 'body', false)]
        public array $networkConfig,
    ) {}
}
