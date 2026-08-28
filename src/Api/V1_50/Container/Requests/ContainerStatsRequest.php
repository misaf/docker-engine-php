<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_50\Container\Requests;

use Misaf\DockerEngine\Generated\GeneratedRequest;
use Misaf\DockerEngine\Generated\RequestParameter;
use Misaf\DockerEngine\Serialization\Undefined;

final readonly class ContainerStatsRequest extends GeneratedRequest
{
    public function __construct(
        #[RequestParameter('id', 'path', false)]
        public string|\Misaf\DockerEngine\ValueObjects\ContainerId $id,
        #[RequestParameter('stream', 'query', false)]
        public bool|Undefined $stream = Undefined::Value,
        #[RequestParameter('one-shot', 'query', false)]
        public bool|Undefined $oneShot = Undefined::Value,
    ) {}
}
