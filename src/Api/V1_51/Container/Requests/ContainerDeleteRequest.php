<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_51\Container\Requests;

use Misaf\DockerEngine\Generated\GeneratedRequest;
use Misaf\DockerEngine\Generated\RequestParameter;
use Misaf\DockerEngine\Serialization\Undefined;

final readonly class ContainerDeleteRequest extends GeneratedRequest
{
    public function __construct(
        #[RequestParameter('id', 'path', false)]
        public string|\Misaf\DockerEngine\ValueObjects\ContainerId $id,
        #[RequestParameter('v', 'query', false)]
        public bool|Undefined $v = Undefined::Value,
        #[RequestParameter('force', 'query', false)]
        public bool|Undefined $force = Undefined::Value,
        #[RequestParameter('link', 'query', false)]
        public bool|Undefined $link = Undefined::Value,
    ) {}
}
