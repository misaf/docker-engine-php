<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_55\Network\Requests;

use Misaf\DockerEngine\Generated\GeneratedRequest;
use Misaf\DockerEngine\Generated\RequestParameter;

final readonly class NetworkDisconnectRequest extends GeneratedRequest
{
    /**
     * @param \Misaf\DockerEngine\Api\V1_55\Schemas\NetworkDisconnectRequest $container
     */
    public function __construct(
        #[RequestParameter('id', 'path', false)]
        public string|\Misaf\DockerEngine\ValueObjects\NetworkId $id,
        #[RequestParameter('container', 'body', false)]
        public \Misaf\DockerEngine\Api\V1_55\Schemas\NetworkDisconnectRequest $container,
    ) {}
}
