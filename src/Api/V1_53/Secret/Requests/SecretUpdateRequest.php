<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_53\Secret\Requests;

use Misaf\DockerEngine\Generated\GeneratedRequest;
use Misaf\DockerEngine\Generated\RequestParameter;
use Misaf\DockerEngine\Serialization\Undefined;

final readonly class SecretUpdateRequest extends GeneratedRequest
{
    /**
     * @param \Misaf\DockerEngine\Api\V1_53\Schemas\SecretSpec|Undefined $body
     */
    public function __construct(
        #[RequestParameter('id', 'path', false)]
        public string|\Misaf\DockerEngine\ValueObjects\SecretId $id,
        #[RequestParameter('version', 'query', false)]
        public int $version,
        #[RequestParameter('body', 'body', false)]
        public \Misaf\DockerEngine\Api\V1_53\Schemas\SecretSpec|Undefined $body = Undefined::Value,
    ) {}
}
