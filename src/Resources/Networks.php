<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Resources;

use Misaf\DockerEngine\Contracts\NetworkApi;
use Misaf\DockerEngine\Dto\Network\NetworkSummary;
use Misaf\DockerEngine\Mapping\StableResponseMapper;
use Misaf\DockerEngine\Raw\RawApi;

final readonly class Networks implements NetworkApi
{
    public function __construct(
        private RawApi $raw,
        private StableResponseMapper $mapper = new StableResponseMapper(),
    ) {}

    /**
     * @param array<string, list<string>> $filters
     * @return list<NetworkSummary>
     */
    public function list(array $filters = []): array
    {
        $data = $this->raw->request('GET', '/networks', [] === $filters ? [] : [
            'filters' => json_encode($filters, JSON_THROW_ON_ERROR),
        ])->json();

        return array_map(
            fn(array $item): NetworkSummary => $this->mapper->networkSummary($item),
            array_values(array_filter($data, 'is_array')),
        );
    }
}
