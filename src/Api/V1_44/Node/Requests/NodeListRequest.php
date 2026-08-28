<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_44\Node\Requests;

use Misaf\DockerEngine\Generated\GeneratedRequest;
use Misaf\DockerEngine\Generated\RequestParameter;
use Misaf\DockerEngine\Serialization\Undefined;

final readonly class NodeListRequest extends GeneratedRequest
{
    public function __construct(
        #[RequestParameter('filters', 'query', false)]
        public string|Undefined $filters = Undefined::Value,
    ) {}
}
