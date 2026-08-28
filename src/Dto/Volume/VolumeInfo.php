<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Dto\Volume;

use Misaf\DockerEngine\ValueObjects\VolumeName;

final readonly class VolumeInfo
{
    /** @param array<string, string> $labels */
    public function __construct(
        public VolumeName $name,
        public string $driver,
        public string $mountpoint,
        public string $scope,
        public array $labels = [],
    ) {}
}
