<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_43\Plugin\Requests;

use Misaf\DockerEngine\Generated\GeneratedRequest;
use Misaf\DockerEngine\Generated\RequestParameter;
use Misaf\DockerEngine\Serialization\Undefined;

final readonly class PluginSetRequest extends GeneratedRequest
{
    /**
     * @param list<string>|Undefined $body
     */
    public function __construct(
        #[RequestParameter('name', 'path', false)]
        public string|\Misaf\DockerEngine\ValueObjects\PluginName $name,
        #[RequestParameter('body', 'body', false)]
        public array|Undefined $body = Undefined::Value,
    ) {}
}
