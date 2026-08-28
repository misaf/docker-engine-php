<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_54\Config\Requests;

use Misaf\DockerEngine\Generated\GeneratedRequest;
use Misaf\DockerEngine\Generated\RequestParameter;
use Misaf\DockerEngine\Serialization\Undefined;

final readonly class ConfigCreateRequest extends GeneratedRequest
{
    /**
     * @param \Misaf\DockerEngine\Api\V1_54\Schemas\ConfigSpec|Undefined $body
     */
    public function __construct(
        #[RequestParameter('body', 'body', false)]
        public \Misaf\DockerEngine\Api\V1_54\Schemas\ConfigSpec|Undefined $body = Undefined::Value,
    ) {}
}
