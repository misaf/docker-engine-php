<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_54\Container\Requests;

use Misaf\DockerEngine\Generated\GeneratedRequest;
use Misaf\DockerEngine\Generated\RequestParameter;

final readonly class ContainerUpdateRequest extends GeneratedRequest
{
    /**
     * @param \Misaf\DockerEngine\Api\V1_54\Schemas\Resources $update
     */
    public function __construct(
        #[RequestParameter('id', 'path', false)]
        public string|\Misaf\DockerEngine\ValueObjects\ContainerId $id,
        #[RequestParameter('update', 'body', false)]
        public \Misaf\DockerEngine\Api\V1_54\Schemas\Resources $update,
    ) {}
}
