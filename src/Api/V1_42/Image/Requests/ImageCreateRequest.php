<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_42\Image\Requests;

use Misaf\DockerEngine\Generated\GeneratedRequest;
use Misaf\DockerEngine\Generated\RequestParameter;
use Misaf\DockerEngine\Serialization\Undefined;

final readonly class ImageCreateRequest extends GeneratedRequest
{
    /**
     * @param list<string>|Undefined $changes
     */
    public function __construct(
        #[RequestParameter('fromImage', 'query', false)]
        public string|Undefined $fromImage = Undefined::Value,
        #[RequestParameter('fromSrc', 'query', false)]
        public string|Undefined $fromSrc = Undefined::Value,
        #[RequestParameter('repo', 'query', false)]
        public string|Undefined $repo = Undefined::Value,
        #[RequestParameter('tag', 'query', false)]
        public string|Undefined $tag = Undefined::Value,
        #[RequestParameter('message', 'query', false)]
        public string|Undefined $message = Undefined::Value,
        #[RequestParameter('inputImage', 'body', false)]
        public string|Undefined $inputImage = Undefined::Value,
        #[RequestParameter('X-Registry-Auth', 'header', false)]
        public string|Undefined $xRegistryAuth = Undefined::Value,
        #[RequestParameter('changes', 'query', false)]
        public array|Undefined $changes = Undefined::Value,
        #[RequestParameter('platform', 'query', false)]
        public string|Undefined $platform = Undefined::Value,
    ) {}
}
