<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Resources;

use Misaf\DockerEngine\Contracts\ImageApi;
use Misaf\DockerEngine\Dto\Image\ImageSummary;
use Misaf\DockerEngine\Mapping\StableResponseMapper;
use Misaf\DockerEngine\Raw\RawApi;
use Misaf\DockerEngine\Streaming\ProgressStream;
use Misaf\DockerEngine\ValueObjects\ImageReference;

final readonly class Images implements ImageApi
{
    public function __construct(
        private RawApi $raw,
        private StableResponseMapper $mapper = new StableResponseMapper(),
    ) {}

    /** @return list<ImageSummary> */
    public function list(bool $all = false): array
    {
        $data = $this->raw->request('GET', '/images/json', ['all' => $all])->json();

        return array_map(
            fn(array $item): ImageSummary => $this->mapper->imageSummary($item),
            array_values(array_filter($data, 'is_array')),
        );
    }

    public function pull(ImageReference|string $image, ?string $registryAuth = null): ProgressStream
    {
        $image = $image instanceof ImageReference ? $image : new ImageReference($image);
        $headers = null === $registryAuth ? [] : ['X-Registry-Auth' => $registryAuth];
        $query = ['fromImage' => $image->isPinned() ? (string) $image : $image->repository];

        if ( ! $image->isPinned()) {
            $query['tag'] = $image->tag;
        }

        return new ProgressStream($this->raw->stream('POST', '/images/create', $query, $headers)->stream);
    }
}
