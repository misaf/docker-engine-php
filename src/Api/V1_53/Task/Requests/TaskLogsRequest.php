<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_53\Task\Requests;

use Misaf\DockerEngine\Generated\GeneratedRequest;
use Misaf\DockerEngine\Generated\RequestParameter;
use Misaf\DockerEngine\Serialization\Undefined;

final readonly class TaskLogsRequest extends GeneratedRequest
{
    public function __construct(
        #[RequestParameter('id', 'path', false)]
        public string|\Misaf\DockerEngine\ValueObjects\TaskId $id,
        #[RequestParameter('details', 'query', false)]
        public bool|Undefined $details = Undefined::Value,
        #[RequestParameter('follow', 'query', false)]
        public bool|Undefined $follow = Undefined::Value,
        #[RequestParameter('stdout', 'query', false)]
        public bool|Undefined $stdout = Undefined::Value,
        #[RequestParameter('stderr', 'query', false)]
        public bool|Undefined $stderr = Undefined::Value,
        #[RequestParameter('since', 'query', false)]
        public int|Undefined $since = Undefined::Value,
        #[RequestParameter('timestamps', 'query', false)]
        public bool|Undefined $timestamps = Undefined::Value,
        #[RequestParameter('tail', 'query', false)]
        public string|Undefined $tail = Undefined::Value,
    ) {}
}
