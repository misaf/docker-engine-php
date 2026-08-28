<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_53\Image\Requests;

use Misaf\DockerEngine\Generated\GeneratedRequest;
use Misaf\DockerEngine\Generated\RequestParameter;
use Misaf\DockerEngine\Serialization\Undefined;

final readonly class ImageTagRequest extends GeneratedRequest
{
    public function __construct(
        #[RequestParameter('name', 'path', false)]
        public string|\Misaf\DockerEngine\ValueObjects\ImageReference $name,
        #[RequestParameter('repo', 'query', false)]
        public string|Undefined $repo = Undefined::Value,
        #[RequestParameter('tag', 'query', false)]
        public string|Undefined $tag = Undefined::Value,
    ) {}
}
