<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_41\Exec\Requests;

use Misaf\DockerEngine\Generated\GeneratedRequest;
use Misaf\DockerEngine\Generated\RequestParameter;

final readonly class ExecInspectRequest extends GeneratedRequest
{
    public function __construct(
        #[RequestParameter('id', 'path', false)]
        public string|\Misaf\DockerEngine\ValueObjects\ExecId $id,
    ) {}
}
