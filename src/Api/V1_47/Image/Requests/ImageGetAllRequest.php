<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_47\Image\Requests;

use Misaf\DockerEngine\Generated\GeneratedRequest;
use Misaf\DockerEngine\Generated\RequestParameter;
use Misaf\DockerEngine\Serialization\Undefined;

final readonly class ImageGetAllRequest extends GeneratedRequest
{
    /**
     * @param list<string>|Undefined $names
     */
    public function __construct(
        #[RequestParameter('names', 'query', false)]
        public array|Undefined $names = Undefined::Value,
    ) {}
}
