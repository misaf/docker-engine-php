<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_55\Image\Requests;

use Misaf\DockerEngine\Generated\GeneratedRequest;
use Misaf\DockerEngine\Generated\RequestParameter;
use Misaf\DockerEngine\Serialization\Undefined;

final readonly class ImageAttestationsRequest extends GeneratedRequest
{
    /**
     * @param list<string>|Undefined $platform
     * @param list<string>|Undefined $type
     */
    public function __construct(
        #[RequestParameter('name', 'path', false)]
        public string|\Misaf\DockerEngine\ValueObjects\ImageReference $name,
        #[RequestParameter('platform', 'query', true)]
        public array|Undefined $platform = Undefined::Value,
        #[RequestParameter('type', 'query', true)]
        public array|Undefined $type = Undefined::Value,
        #[RequestParameter('statement', 'query', false)]
        public bool|Undefined $statement = Undefined::Value,
    ) {}
}
