<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_53\Container\Requests;

use Misaf\DockerEngine\Generated\GeneratedRequest;
use Misaf\DockerEngine\Generated\RequestParameter;

final readonly class ContainerArchiveInfoRequest extends GeneratedRequest
{
    public function __construct(
        #[RequestParameter('id', 'path', false)]
        public string|\Misaf\DockerEngine\ValueObjects\ContainerId $id,
        #[RequestParameter('path', 'query', false)]
        public string $path,
    ) {}
}
