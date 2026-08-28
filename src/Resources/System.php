<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Resources;

use Misaf\DockerEngine\Contracts\SystemApi;
use Misaf\DockerEngine\Dto\System\EngineInfo;
use Misaf\DockerEngine\Dto\System\EngineVersion;
use Misaf\DockerEngine\Mapping\StableResponseMapper;
use Misaf\DockerEngine\Raw\RawApi;

final readonly class System implements SystemApi
{
    public function __construct(
        private RawApi $raw,
        private StableResponseMapper $mapper = new StableResponseMapper(),
    ) {}

    public function ping(): string
    {
        return $this->raw->request('GET', '/_ping')->body;
    }

    public function version(): EngineVersion
    {
        return $this->mapper->engineVersion($this->raw->request('GET', '/version')->json());
    }

    public function info(): EngineInfo
    {
        return $this->mapper->engineInfo($this->raw->request('GET', '/info')->json());
    }
}
