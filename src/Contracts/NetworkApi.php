<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Contracts;

use Misaf\DockerEngine\Dto\Network\NetworkSummary;

interface NetworkApi
{
    /**
     * @param array<string, list<string>> $filters
     * @return list<NetworkSummary>
     */
    public function list(array $filters = []): array;
}
