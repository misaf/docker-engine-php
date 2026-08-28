<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_45\Container\Requests;

use Misaf\DockerEngine\Generated\GeneratedRequest;
use Misaf\DockerEngine\Generated\RequestParameter;
use Misaf\DockerEngine\Serialization\Undefined;

final readonly class PutContainerArchiveRequest extends GeneratedRequest
{
    /**
     * @param string|\Misaf\DockerEngine\Contracts\Stream\Stream $inputStream
     */
    public function __construct(
        #[RequestParameter('id', 'path', false)]
        public string|\Misaf\DockerEngine\ValueObjects\ContainerId $id,
        #[RequestParameter('path', 'query', false)]
        public string $path,
        #[RequestParameter('inputStream', 'body', false)]
        public string|\Misaf\DockerEngine\Contracts\Stream\Stream $inputStream,
        #[RequestParameter('noOverwriteDirNonDir', 'query', false)]
        public string|Undefined $noOverwriteDirNonDir = Undefined::Value,
        #[RequestParameter('copyUIDGID', 'query', false)]
        public string|Undefined $copyUidgid = Undefined::Value,
    ) {}
}
