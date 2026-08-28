<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_50\System\Requests;

use Misaf\DockerEngine\Generated\GeneratedRequest;
use Misaf\DockerEngine\Generated\RequestParameter;
use Misaf\DockerEngine\Serialization\Undefined;

final readonly class SystemAuthRequest extends GeneratedRequest
{
    /**
     * @param \Misaf\DockerEngine\Api\V1_50\Schemas\AuthConfig|Undefined $authConfig
     */
    public function __construct(
        #[RequestParameter('authConfig', 'body', false)]
        public \Misaf\DockerEngine\Api\V1_50\Schemas\AuthConfig|Undefined $authConfig = Undefined::Value,
    ) {}
}
