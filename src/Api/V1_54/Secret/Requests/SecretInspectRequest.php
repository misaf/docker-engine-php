<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_54\Secret\Requests;

use Misaf\DockerEngine\Generated\GeneratedRequest;
use Misaf\DockerEngine\Generated\RequestParameter;

final readonly class SecretInspectRequest extends GeneratedRequest
{
    public function __construct(
        #[RequestParameter('id', 'path', false)]
        public string|\Misaf\DockerEngine\ValueObjects\SecretId $id,
    ) {}
}
