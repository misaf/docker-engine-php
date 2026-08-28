<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_45\Secret\Requests;

use Misaf\DockerEngine\Generated\GeneratedRequest;
use Misaf\DockerEngine\Generated\RequestParameter;
use Misaf\DockerEngine\Serialization\Undefined;

final readonly class SecretCreateRequest extends GeneratedRequest
{
    /**
     * @param \Misaf\DockerEngine\Api\V1_45\Schemas\SecretSpec|Undefined $body
     */
    public function __construct(
        #[RequestParameter('body', 'body', false)]
        public \Misaf\DockerEngine\Api\V1_45\Schemas\SecretSpec|Undefined $body = Undefined::Value,
    ) {}
}
