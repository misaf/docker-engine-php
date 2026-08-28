<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_52\Container\Requests;

use Misaf\DockerEngine\Generated\GeneratedRequest;
use Misaf\DockerEngine\Generated\RequestParameter;
use Misaf\DockerEngine\Serialization\Undefined;

final readonly class ContainerCreateRequest extends GeneratedRequest
{
    /**
     * @param \Misaf\DockerEngine\Api\V1_52\Schemas\ContainerConfig $body
     */
    public function __construct(
        #[RequestParameter('body', 'body', false)]
        public \Misaf\DockerEngine\Api\V1_52\Schemas\ContainerConfig $body,
        #[RequestParameter('name', 'query', false)]
        public string|Undefined $name = Undefined::Value,
        #[RequestParameter('platform', 'query', false)]
        public string|Undefined $platform = Undefined::Value,
    ) {}
}
