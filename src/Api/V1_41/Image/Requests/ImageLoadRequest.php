<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_41\Image\Requests;

use Misaf\DockerEngine\Generated\GeneratedRequest;
use Misaf\DockerEngine\Generated\RequestParameter;
use Misaf\DockerEngine\Serialization\Undefined;

final readonly class ImageLoadRequest extends GeneratedRequest
{
    /**
     * @param string|\Misaf\DockerEngine\Contracts\Stream\Stream|Undefined $imagesTarball
     */
    public function __construct(
        #[RequestParameter('imagesTarball', 'body', false)]
        public string|\Misaf\DockerEngine\Contracts\Stream\Stream|Undefined $imagesTarball = Undefined::Value,
        #[RequestParameter('quiet', 'query', false)]
        public bool|Undefined $quiet = Undefined::Value,
    ) {}
}
