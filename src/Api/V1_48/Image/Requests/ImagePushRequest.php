<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_48\Image\Requests;

use Misaf\DockerEngine\Generated\GeneratedRequest;
use Misaf\DockerEngine\Generated\RequestParameter;
use Misaf\DockerEngine\Serialization\Undefined;

final readonly class ImagePushRequest extends GeneratedRequest
{
    public function __construct(
        #[RequestParameter('name', 'path', false)]
        public string|\Misaf\DockerEngine\ValueObjects\ImageReference $name,
        #[RequestParameter('X-Registry-Auth', 'header', false)]
        public string $xRegistryAuth,
        #[RequestParameter('tag', 'query', false)]
        public string|Undefined $tag = Undefined::Value,
        #[RequestParameter('platform', 'query', false)]
        public string|Undefined $platform = Undefined::Value,
    ) {}
}
