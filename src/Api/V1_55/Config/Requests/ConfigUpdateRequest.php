<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_55\Config\Requests;

use Misaf\DockerEngine\Generated\GeneratedRequest;
use Misaf\DockerEngine\Generated\RequestParameter;
use Misaf\DockerEngine\Serialization\Undefined;

final readonly class ConfigUpdateRequest extends GeneratedRequest
{
    /**
     * @param \Misaf\DockerEngine\Api\V1_55\Schemas\ConfigSpec|Undefined $body
     */
    public function __construct(
        #[RequestParameter('id', 'path', false)]
        public string|\Misaf\DockerEngine\ValueObjects\ConfigId $id,
        #[RequestParameter('version', 'query', false)]
        public int $version,
        #[RequestParameter('body', 'body', false)]
        public \Misaf\DockerEngine\Api\V1_55\Schemas\ConfigSpec|Undefined $body = Undefined::Value,
    ) {}
}
