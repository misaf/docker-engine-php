<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_51\Service\Requests;

use Misaf\DockerEngine\Generated\GeneratedRequest;
use Misaf\DockerEngine\Generated\RequestParameter;
use Misaf\DockerEngine\Serialization\Undefined;

final readonly class ServiceUpdateRequest extends GeneratedRequest
{
    /**
     * @param \Misaf\DockerEngine\Api\V1_51\Schemas\ServiceSpec $body
     */
    public function __construct(
        #[RequestParameter('id', 'path', false)]
        public string|\Misaf\DockerEngine\ValueObjects\ServiceId $id,
        #[RequestParameter('body', 'body', false)]
        public \Misaf\DockerEngine\Api\V1_51\Schemas\ServiceSpec $body,
        #[RequestParameter('version', 'query', false)]
        public int $version,
        #[RequestParameter('registryAuthFrom', 'query', false)]
        public string|Undefined $registryAuthFrom = Undefined::Value,
        #[RequestParameter('rollback', 'query', false)]
        public string|Undefined $rollback = Undefined::Value,
        #[RequestParameter('X-Registry-Auth', 'header', false)]
        public string|Undefined $xRegistryAuth = Undefined::Value,
    ) {}
}
