<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_48\Image\Requests;

use Misaf\DockerEngine\Generated\GeneratedRequest;
use Misaf\DockerEngine\Generated\RequestParameter;
use Misaf\DockerEngine\Serialization\Undefined;

final readonly class ImageListRequest extends GeneratedRequest
{
    public function __construct(
        #[RequestParameter('all', 'query', false)]
        public bool|Undefined $all = Undefined::Value,
        #[RequestParameter('filters', 'query', false)]
        public string|Undefined $filters = Undefined::Value,
        #[RequestParameter('shared-size', 'query', false)]
        public bool|Undefined $sharedSize = Undefined::Value,
        #[RequestParameter('digests', 'query', false)]
        public bool|Undefined $digests = Undefined::Value,
        #[RequestParameter('manifests', 'query', false)]
        public bool|Undefined $manifests = Undefined::Value,
    ) {}
}
