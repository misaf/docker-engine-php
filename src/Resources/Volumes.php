<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Resources;

use Misaf\DockerEngine\Contracts\Api\VolumeApi;
use Misaf\DockerEngine\Dto\Volume\VolumeInfo;
use Misaf\DockerEngine\Exceptions\InvalidResponseException;
use Misaf\DockerEngine\Mapping\StableResponseMapper;
use Misaf\DockerEngine\Raw\RawApi;

final readonly class Volumes implements VolumeApi
{
    public function __construct(
        private RawApi $raw,
        private StableResponseMapper $mapper = new StableResponseMapper(),
    ) {}

    /**
     * @param array<string, list<string>> $filters
     * @return list<VolumeInfo>
     */
    public function list(array $filters = []): array
    {
        $data = $this->raw->request('GET', '/volumes', [] === $filters ? [] : [
            'filters' => json_encode($filters, JSON_THROW_ON_ERROR),
        ])->json();
        $volumes = $data['Volumes'] ?? [];

        if ( ! is_array($volumes)) {
            throw new InvalidResponseException('Docker returned an invalid volume list.');
        }

        return array_map(
            fn(array $item): VolumeInfo => $this->mapper->volumeInfo($item),
            array_values(array_filter($volumes, 'is_array')),
        );
    }
}
