<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Contracts\Api;

use Misaf\DockerEngine\Dto\System\EngineInfo;
use Misaf\DockerEngine\Dto\System\EngineVersion;

interface SystemApi
{
    public function ping(): string;

    public function version(): EngineVersion;

    public function info(): EngineInfo;
}
