<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_55\Container\Requests;

use Misaf\DockerEngine\Generated\GeneratedRequest;
use Misaf\DockerEngine\Generated\RequestParameter;
use Misaf\DockerEngine\Serialization\Undefined;

final readonly class ContainerAttachRequest extends GeneratedRequest
{
    public function __construct(
        #[RequestParameter('id', 'path', false)]
        public string|\Misaf\DockerEngine\ValueObjects\ContainerId $id,
        #[RequestParameter('detachKeys', 'query', false)]
        public string|Undefined $detachKeys = Undefined::Value,
        #[RequestParameter('logs', 'query', false)]
        public bool|Undefined $logs = Undefined::Value,
        #[RequestParameter('stream', 'query', false)]
        public bool|Undefined $stream = Undefined::Value,
        #[RequestParameter('stdin', 'query', false)]
        public bool|Undefined $stdin = Undefined::Value,
        #[RequestParameter('stdout', 'query', false)]
        public bool|Undefined $stdout = Undefined::Value,
        #[RequestParameter('stderr', 'query', false)]
        public bool|Undefined $stderr = Undefined::Value,
    ) {}
}
