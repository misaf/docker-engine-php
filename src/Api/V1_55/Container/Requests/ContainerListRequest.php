<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_55\Container\Requests;

use Misaf\DockerEngine\Generated\GeneratedRequest;
use Misaf\DockerEngine\Generated\RequestParameter;
use Misaf\DockerEngine\Serialization\Undefined;

final readonly class ContainerListRequest extends GeneratedRequest
{
    public function __construct(
        #[RequestParameter('all', 'query', false)]
        public bool|Undefined $all = Undefined::Value,
        #[RequestParameter('limit', 'query', false)]
        public int|Undefined $limit = Undefined::Value,
        #[RequestParameter('size', 'query', false)]
        public bool|Undefined $size = Undefined::Value,
        #[RequestParameter('filters', 'query', false)]
        public string|Undefined $filters = Undefined::Value,
    ) {}
}
