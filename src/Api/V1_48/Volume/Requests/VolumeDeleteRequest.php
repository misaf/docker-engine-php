<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_48\Volume\Requests;

use Misaf\DockerEngine\Generated\GeneratedRequest;
use Misaf\DockerEngine\Generated\RequestParameter;
use Misaf\DockerEngine\Serialization\Undefined;

final readonly class VolumeDeleteRequest extends GeneratedRequest
{
    public function __construct(
        #[RequestParameter('name', 'path', false)]
        public string|\Misaf\DockerEngine\ValueObjects\VolumeName $name,
        #[RequestParameter('force', 'query', false)]
        public bool|Undefined $force = Undefined::Value,
    ) {}
}
