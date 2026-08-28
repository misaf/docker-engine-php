<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_46\Plugin\Requests;

use Misaf\DockerEngine\Generated\GeneratedRequest;
use Misaf\DockerEngine\Generated\RequestParameter;
use Misaf\DockerEngine\Serialization\Undefined;

final readonly class PluginCreateRequest extends GeneratedRequest
{
    /**
     * @param string|\Misaf\DockerEngine\Contracts\Stream\Stream|Undefined $tarContext
     */
    public function __construct(
        #[RequestParameter('name', 'query', false)]
        public string $name,
        #[RequestParameter('tarContext', 'body', false)]
        public string|\Misaf\DockerEngine\Contracts\Stream\Stream|Undefined $tarContext = Undefined::Value,
    ) {}
}
