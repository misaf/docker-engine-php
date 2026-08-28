<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_40\Plugin\Requests;

use Misaf\DockerEngine\Generated\GeneratedRequest;
use Misaf\DockerEngine\Generated\RequestParameter;

final readonly class PluginInspectRequest extends GeneratedRequest
{
    public function __construct(
        #[RequestParameter('name', 'path', false)]
        public string|\Misaf\DockerEngine\ValueObjects\PluginName $name,
    ) {}
}
