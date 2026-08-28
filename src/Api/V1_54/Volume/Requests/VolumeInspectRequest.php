<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_54\Volume\Requests;

use Misaf\DockerEngine\Generated\GeneratedRequest;
use Misaf\DockerEngine\Generated\RequestParameter;

final readonly class VolumeInspectRequest extends GeneratedRequest
{
    public function __construct(
        #[RequestParameter('name', 'path', false)]
        public string|\Misaf\DockerEngine\ValueObjects\VolumeName $name,
    ) {}
}
