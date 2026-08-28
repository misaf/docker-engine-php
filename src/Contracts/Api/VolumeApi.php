<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Contracts\Api;

use Misaf\DockerEngine\Dto\Volume\VolumeInfo;

interface VolumeApi
{
    /**
     * @param array<string, list<string>> $filters
     * @return list<VolumeInfo>
     */
    public function list(array $filters = []): array;
}
