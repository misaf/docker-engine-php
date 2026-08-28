<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_48\Plugin\Requests;

use Misaf\DockerEngine\Generated\GeneratedRequest;
use Misaf\DockerEngine\Generated\RequestParameter;
use Misaf\DockerEngine\Serialization\ArrayOf;
use Misaf\DockerEngine\Serialization\Undefined;

final readonly class PluginUpgradeRequest extends GeneratedRequest
{
    /**
     * @param list<\Misaf\DockerEngine\Api\V1_48\Schemas\PluginPrivilege>|Undefined $body
     */
    public function __construct(
        #[RequestParameter('name', 'path', false)]
        public string|\Misaf\DockerEngine\ValueObjects\PluginName $name,
        #[RequestParameter('remote', 'query', false)]
        public string $remote,
        #[RequestParameter('X-Registry-Auth', 'header', false)]
        public string|Undefined $xRegistryAuth = Undefined::Value,
        #[RequestParameter('body', 'body', false)]
        #[ArrayOf(\Misaf\DockerEngine\Api\V1_48\Schemas\PluginPrivilege::class)]
        public array|Undefined $body = Undefined::Value,
    ) {}
}
