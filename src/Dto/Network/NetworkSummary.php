<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Dto\Network;

use Misaf\DockerEngine\ValueObjects\NetworkId;

final readonly class NetworkSummary
{
    /** @param array<string, string> $labels */
    public function __construct(
        public NetworkId $id,
        public string $name,
        public string $driver,
        public string $scope,
        public array $labels = [],
    ) {}
}
