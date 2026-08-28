<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_48\System\Requests;

use Misaf\DockerEngine\Generated\GeneratedRequest;
use Misaf\DockerEngine\Generated\RequestParameter;
use Misaf\DockerEngine\Serialization\Undefined;

final readonly class SystemDataUsageRequest extends GeneratedRequest
{
    /**
     * @param list<string>|Undefined $type
     */
    public function __construct(
        #[RequestParameter('type', 'query', true)]
        public array|Undefined $type = Undefined::Value,
    ) {}
}
