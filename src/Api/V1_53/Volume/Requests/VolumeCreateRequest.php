<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_53\Volume\Requests;

use Misaf\DockerEngine\Generated\GeneratedRequest;
use Misaf\DockerEngine\Generated\RequestParameter;

final readonly class VolumeCreateRequest extends GeneratedRequest
{
    /**
     * @param \Misaf\DockerEngine\Api\V1_53\Schemas\VolumeCreateRequest $volumeConfig
     */
    public function __construct(
        #[RequestParameter('volumeConfig', 'body', false)]
        public \Misaf\DockerEngine\Api\V1_53\Schemas\VolumeCreateRequest $volumeConfig,
    ) {}
}
