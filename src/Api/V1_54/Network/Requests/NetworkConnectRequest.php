<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_54\Network\Requests;

use Misaf\DockerEngine\Generated\GeneratedRequest;
use Misaf\DockerEngine\Generated\RequestParameter;

final readonly class NetworkConnectRequest extends GeneratedRequest
{
    /**
     * @param \Misaf\DockerEngine\Api\V1_54\Schemas\NetworkConnectRequest $container
     */
    public function __construct(
        #[RequestParameter('id', 'path', false)]
        public string|\Misaf\DockerEngine\ValueObjects\NetworkId $id,
        #[RequestParameter('container', 'body', false)]
        public \Misaf\DockerEngine\Api\V1_54\Schemas\NetworkConnectRequest $container,
    ) {}
}
