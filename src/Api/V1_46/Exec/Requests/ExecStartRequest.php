<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_46\Exec\Requests;

use Misaf\DockerEngine\Generated\GeneratedRequest;
use Misaf\DockerEngine\Generated\RequestParameter;
use Misaf\DockerEngine\Serialization\Undefined;

final readonly class ExecStartRequest extends GeneratedRequest
{
    /**
     * @param array<string, mixed>|Undefined $execStartConfig
     */
    public function __construct(
        #[RequestParameter('id', 'path', false)]
        public string|\Misaf\DockerEngine\ValueObjects\ExecId $id,
        #[RequestParameter('execStartConfig', 'body', false)]
        public array|Undefined $execStartConfig = Undefined::Value,
    ) {}
}
