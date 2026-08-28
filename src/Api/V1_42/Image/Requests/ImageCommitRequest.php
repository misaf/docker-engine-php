<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_42\Image\Requests;

use Misaf\DockerEngine\Generated\GeneratedRequest;
use Misaf\DockerEngine\Generated\RequestParameter;
use Misaf\DockerEngine\Serialization\Undefined;

final readonly class ImageCommitRequest extends GeneratedRequest
{
    /**
     * @param \Misaf\DockerEngine\Api\V1_42\Schemas\ContainerConfig|Undefined $containerConfig
     */
    public function __construct(
        #[RequestParameter('containerConfig', 'body', false)]
        public \Misaf\DockerEngine\Api\V1_42\Schemas\ContainerConfig|Undefined $containerConfig = Undefined::Value,
        #[RequestParameter('container', 'query', false)]
        public string|Undefined $container = Undefined::Value,
        #[RequestParameter('repo', 'query', false)]
        public string|Undefined $repo = Undefined::Value,
        #[RequestParameter('tag', 'query', false)]
        public string|Undefined $tag = Undefined::Value,
        #[RequestParameter('comment', 'query', false)]
        public string|Undefined $comment = Undefined::Value,
        #[RequestParameter('author', 'query', false)]
        public string|Undefined $author = Undefined::Value,
        #[RequestParameter('pause', 'query', false)]
        public bool|Undefined $pause = Undefined::Value,
        #[RequestParameter('changes', 'query', false)]
        public string|Undefined $changes = Undefined::Value,
    ) {}
}
