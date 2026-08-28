<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_40\Plugin\Requests;

use Misaf\DockerEngine\Generated\GeneratedRequest;
use Misaf\DockerEngine\Generated\RequestParameter;
use Misaf\DockerEngine\Serialization\Undefined;

final readonly class PluginEnableRequest extends GeneratedRequest
{
    public function __construct(
        #[RequestParameter('name', 'path', false)]
        public string|\Misaf\DockerEngine\ValueObjects\PluginName $name,
        #[RequestParameter('timeout', 'query', false)]
        public int|Undefined $timeout = Undefined::Value,
    ) {}
}
