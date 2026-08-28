<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_41\Secret\Requests;

use Misaf\DockerEngine\Generated\GeneratedRequest;
use Misaf\DockerEngine\Generated\RequestParameter;

final readonly class SecretDeleteRequest extends GeneratedRequest
{
    public function __construct(
        #[RequestParameter('id', 'path', false)]
        public string|\Misaf\DockerEngine\ValueObjects\SecretId $id,
    ) {}
}
