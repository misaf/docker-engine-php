<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_40\Container\Requests;

use Misaf\DockerEngine\Generated\GeneratedRequest;
use Misaf\DockerEngine\Generated\RequestParameter;
use Misaf\DockerEngine\Serialization\Undefined;

final readonly class ContainerTopRequest extends GeneratedRequest
{
    public function __construct(
        #[RequestParameter('id', 'path', false)]
        public string|\Misaf\DockerEngine\ValueObjects\ContainerId $id,
        #[RequestParameter('ps_args', 'query', false)]
        public string|Undefined $psArgs = Undefined::Value,
    ) {}
}
