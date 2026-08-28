<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_44\Container\Requests;

use Misaf\DockerEngine\Generated\GeneratedRequest;
use Misaf\DockerEngine\Generated\RequestParameter;
use Misaf\DockerEngine\Serialization\Undefined;

final readonly class ContainerStopRequest extends GeneratedRequest
{
    public function __construct(
        #[RequestParameter('id', 'path', false)]
        public string|\Misaf\DockerEngine\ValueObjects\ContainerId $id,
        #[RequestParameter('signal', 'query', false)]
        public string|Undefined $signal = Undefined::Value,
        #[RequestParameter('t', 'query', false)]
        public int|Undefined $t = Undefined::Value,
    ) {}
}
