<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_51\Image\Requests;

use Misaf\DockerEngine\Generated\GeneratedRequest;
use Misaf\DockerEngine\Generated\RequestParameter;
use Misaf\DockerEngine\Serialization\Undefined;

final readonly class BuildPruneRequest extends GeneratedRequest
{
    public function __construct(
        #[RequestParameter('keep-storage', 'query', false)]
        public int|Undefined $keepStorage = Undefined::Value,
        #[RequestParameter('reserved-space', 'query', false)]
        public int|Undefined $reservedSpace = Undefined::Value,
        #[RequestParameter('max-used-space', 'query', false)]
        public int|Undefined $maxUsedSpace = Undefined::Value,
        #[RequestParameter('min-free-space', 'query', false)]
        public int|Undefined $minFreeSpace = Undefined::Value,
        #[RequestParameter('all', 'query', false)]
        public bool|Undefined $all = Undefined::Value,
        #[RequestParameter('filters', 'query', false)]
        public string|Undefined $filters = Undefined::Value,
    ) {}
}
