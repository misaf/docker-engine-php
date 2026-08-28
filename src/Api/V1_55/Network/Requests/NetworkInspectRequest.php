<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_55\Network\Requests;

use Misaf\DockerEngine\Generated\GeneratedRequest;
use Misaf\DockerEngine\Generated\RequestParameter;
use Misaf\DockerEngine\Serialization\Undefined;

final readonly class NetworkInspectRequest extends GeneratedRequest
{
    public function __construct(
        #[RequestParameter('id', 'path', false)]
        public string|\Misaf\DockerEngine\ValueObjects\NetworkId $id,
        #[RequestParameter('verbose', 'query', false)]
        public bool|Undefined $verbose = Undefined::Value,
        #[RequestParameter('scope', 'query', false)]
        public string|Undefined $scope = Undefined::Value,
    ) {}
}
