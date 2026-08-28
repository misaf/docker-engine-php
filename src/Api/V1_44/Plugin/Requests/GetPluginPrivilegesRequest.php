<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_44\Plugin\Requests;

use Misaf\DockerEngine\Generated\GeneratedRequest;
use Misaf\DockerEngine\Generated\RequestParameter;

final readonly class GetPluginPrivilegesRequest extends GeneratedRequest
{
    public function __construct(
        #[RequestParameter('remote', 'query', false)]
        public string $remote,
    ) {}
}
