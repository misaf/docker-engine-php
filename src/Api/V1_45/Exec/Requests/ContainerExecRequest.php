<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_45\Exec\Requests;

use Misaf\DockerEngine\Generated\GeneratedRequest;
use Misaf\DockerEngine\Generated\RequestParameter;

final readonly class ContainerExecRequest extends GeneratedRequest
{
    /**
     * @param array<string, mixed> $execConfig
     */
    public function __construct(
        #[RequestParameter('execConfig', 'body', false)]
        public array $execConfig,
        #[RequestParameter('id', 'path', false)]
        public string|\Misaf\DockerEngine\ValueObjects\ExecId $id,
    ) {}
}
