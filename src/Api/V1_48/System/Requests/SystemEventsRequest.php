<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_48\System\Requests;

use Misaf\DockerEngine\Generated\GeneratedRequest;
use Misaf\DockerEngine\Generated\RequestParameter;
use Misaf\DockerEngine\Serialization\Undefined;

final readonly class SystemEventsRequest extends GeneratedRequest
{
    public function __construct(
        #[RequestParameter('since', 'query', false)]
        public string|Undefined $since = Undefined::Value,
        #[RequestParameter('until', 'query', false)]
        public string|Undefined $until = Undefined::Value,
        #[RequestParameter('filters', 'query', false)]
        public string|Undefined $filters = Undefined::Value,
    ) {}
}
