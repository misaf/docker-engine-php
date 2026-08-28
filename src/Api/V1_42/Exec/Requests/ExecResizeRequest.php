<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_42\Exec\Requests;

use Misaf\DockerEngine\Generated\GeneratedRequest;
use Misaf\DockerEngine\Generated\RequestParameter;

final readonly class ExecResizeRequest extends GeneratedRequest
{
    public function __construct(
        #[RequestParameter('id', 'path', false)]
        public string|\Misaf\DockerEngine\ValueObjects\ExecId $id,
        #[RequestParameter('h', 'query', false)]
        public int $h,
        #[RequestParameter('w', 'query', false)]
        public int $w,
    ) {}
}
