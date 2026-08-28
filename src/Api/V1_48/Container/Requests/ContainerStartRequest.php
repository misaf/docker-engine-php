<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_48\Container\Requests;

use Misaf\DockerEngine\Generated\GeneratedRequest;
use Misaf\DockerEngine\Generated\RequestParameter;
use Misaf\DockerEngine\Serialization\Undefined;

final readonly class ContainerStartRequest extends GeneratedRequest
{
    public function __construct(
        #[RequestParameter('id', 'path', false)]
        public string|\Misaf\DockerEngine\ValueObjects\ContainerId $id,
        #[RequestParameter('detachKeys', 'query', false)]
        public string|Undefined $detachKeys = Undefined::Value,
    ) {}
}
