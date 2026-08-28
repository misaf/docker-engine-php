<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_47\Node\Requests;

use Misaf\DockerEngine\Generated\GeneratedRequest;
use Misaf\DockerEngine\Generated\RequestParameter;
use Misaf\DockerEngine\Serialization\Undefined;

final readonly class NodeDeleteRequest extends GeneratedRequest
{
    public function __construct(
        #[RequestParameter('id', 'path', false)]
        public string|\Misaf\DockerEngine\ValueObjects\NodeId $id,
        #[RequestParameter('force', 'query', false)]
        public bool|Undefined $force = Undefined::Value,
    ) {}
}
