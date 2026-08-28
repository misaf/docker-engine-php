<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_49\Network\Requests;

use Misaf\DockerEngine\Generated\GeneratedRequest;
use Misaf\DockerEngine\Generated\RequestParameter;

final readonly class NetworkDisconnectRequest extends GeneratedRequest
{
    /**
     * @param array<string, mixed> $container
     */
    public function __construct(
        #[RequestParameter('id', 'path', false)]
        public string|\Misaf\DockerEngine\ValueObjects\NetworkId $id,
        #[RequestParameter('container', 'body', false)]
        public array $container,
    ) {}
}
