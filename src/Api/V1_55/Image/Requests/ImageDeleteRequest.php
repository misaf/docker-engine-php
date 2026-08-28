<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_55\Image\Requests;

use Misaf\DockerEngine\Generated\GeneratedRequest;
use Misaf\DockerEngine\Generated\RequestParameter;
use Misaf\DockerEngine\Serialization\Undefined;

final readonly class ImageDeleteRequest extends GeneratedRequest
{
    /**
     * @param list<string>|Undefined $platforms
     */
    public function __construct(
        #[RequestParameter('name', 'path', false)]
        public string|\Misaf\DockerEngine\ValueObjects\ImageReference $name,
        #[RequestParameter('force', 'query', false)]
        public bool|Undefined $force = Undefined::Value,
        #[RequestParameter('noprune', 'query', false)]
        public bool|Undefined $noprune = Undefined::Value,
        #[RequestParameter('platforms', 'query', false)]
        public array|Undefined $platforms = Undefined::Value,
    ) {}
}
