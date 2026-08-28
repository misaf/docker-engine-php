<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_41\Service\Requests;

use Misaf\DockerEngine\Generated\GeneratedRequest;
use Misaf\DockerEngine\Generated\RequestParameter;
use Misaf\DockerEngine\Serialization\Undefined;

final readonly class ServiceCreateRequest extends GeneratedRequest
{
    /**
     * @param \Misaf\DockerEngine\Api\V1_41\Schemas\ServiceSpec $body
     */
    public function __construct(
        #[RequestParameter('body', 'body', false)]
        public \Misaf\DockerEngine\Api\V1_41\Schemas\ServiceSpec $body,
        #[RequestParameter('X-Registry-Auth', 'header', false)]
        public string|Undefined $xRegistryAuth = Undefined::Value,
    ) {}
}
