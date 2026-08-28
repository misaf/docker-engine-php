<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_55\Plugin\Requests;

use Misaf\DockerEngine\Generated\GeneratedRequest;
use Misaf\DockerEngine\Generated\RequestParameter;
use Misaf\DockerEngine\Serialization\ArrayOf;
use Misaf\DockerEngine\Serialization\Undefined;

final readonly class PluginPullRequest extends GeneratedRequest
{
    /**
     * @param list<\Misaf\DockerEngine\Api\V1_55\Schemas\PluginPrivilege>|Undefined $body
     */
    public function __construct(
        #[RequestParameter('remote', 'query', false)]
        public string $remote,
        #[RequestParameter('name', 'query', false)]
        public string|Undefined $name = Undefined::Value,
        #[RequestParameter('X-Registry-Auth', 'header', false)]
        public string|Undefined $xRegistryAuth = Undefined::Value,
        #[RequestParameter('body', 'body', false)]
        #[ArrayOf(\Misaf\DockerEngine\Api\V1_55\Schemas\PluginPrivilege::class)]
        public array|Undefined $body = Undefined::Value,
    ) {}
}
