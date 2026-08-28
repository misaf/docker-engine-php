<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_51\Service\Requests;

use Misaf\DockerEngine\Generated\GeneratedRequest;
use Misaf\DockerEngine\Generated\RequestParameter;
use Misaf\DockerEngine\Serialization\Undefined;

final readonly class ServiceInspectRequest extends GeneratedRequest
{
    public function __construct(
        #[RequestParameter('id', 'path', false)]
        public string|\Misaf\DockerEngine\ValueObjects\ServiceId $id,
        #[RequestParameter('insertDefaults', 'query', false)]
        public bool|Undefined $insertDefaults = Undefined::Value,
    ) {}
}
