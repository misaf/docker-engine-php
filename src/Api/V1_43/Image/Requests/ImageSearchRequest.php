<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_43\Image\Requests;

use Misaf\DockerEngine\Generated\GeneratedRequest;
use Misaf\DockerEngine\Generated\RequestParameter;
use Misaf\DockerEngine\Serialization\Undefined;

final readonly class ImageSearchRequest extends GeneratedRequest
{
    public function __construct(
        #[RequestParameter('term', 'query', false)]
        public string $term,
        #[RequestParameter('limit', 'query', false)]
        public int|Undefined $limit = Undefined::Value,
        #[RequestParameter('filters', 'query', false)]
        public string|Undefined $filters = Undefined::Value,
    ) {}
}
