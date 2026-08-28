<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_42\Node\Requests;

use Misaf\DockerEngine\Generated\GeneratedRequest;
use Misaf\DockerEngine\Generated\RequestParameter;

final readonly class NodeInspectRequest extends GeneratedRequest
{
    public function __construct(
        #[RequestParameter('id', 'path', false)]
        public string|\Misaf\DockerEngine\ValueObjects\NodeId $id,
    ) {}
}
