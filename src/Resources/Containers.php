<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Resources;

use Misaf\DockerEngine\Contracts\ContainerApi;
use Misaf\DockerEngine\Dto\Container\ContainerInfo;
use Misaf\DockerEngine\Dto\Container\ContainerSummary;
use Misaf\DockerEngine\Dto\Container\CreateContainer;
use Misaf\DockerEngine\Dto\Container\CreatedContainer;
use Misaf\DockerEngine\Dto\Container\ListContainers;
use Misaf\DockerEngine\Dto\Container\LogsOptions;
use Misaf\DockerEngine\Exceptions\InvalidResponseException;
use Misaf\DockerEngine\Mapping\StableResponseMapper;
use Misaf\DockerEngine\Raw\RawApi;
use Misaf\DockerEngine\Streaming\MultiplexedStream;
use Misaf\DockerEngine\Streaming\RawStream;
use Misaf\DockerEngine\ValueObjects\ContainerId;

final readonly class Containers implements ContainerApi
{
    public function __construct(
        private RawApi $raw,
        private StableResponseMapper $mapper = new StableResponseMapper(),
    ) {}

    /** @return list<ContainerSummary> */
    public function list(?ListContainers $options = null): array
    {
        $options ??= new ListContainers();
        $query = ['all' => $options->all, 'size' => $options->includeSize];

        if (null !== $options->limit) {
            $query['limit'] = $options->limit;
        }

        if ([] !== $options->filters) {
            $query['filters'] = json_encode($options->filters, JSON_THROW_ON_ERROR);
        }

        return array_map(
            fn(array $item): ContainerSummary => $this->mapper->containerSummary($item),
            $this->objects($this->raw->request('GET', '/containers/json', $query)->json()),
        );
    }

    public function create(CreateContainer $request): CreatedContainer
    {
        $query = [];

        if (null !== $request->name) {
            $query['name'] = $request->name;
        }

        if (null !== $request->platform) {
            $query['platform'] = $request->platform;
        }

        $data = $this->raw->request('POST', '/containers/create', $query, body: $request->body())->json();
        $id = $data['Id'] ?? null;

        if ( ! is_string($id) || '' === $id) {
            throw new InvalidResponseException('Docker did not return a container ID.');
        }

        $warnings = $data['Warnings'] ?? [];

        return new CreatedContainer(
            new ContainerId($id),
            is_array($warnings) ? array_values(array_filter($warnings, 'is_string')) : [],
        );
    }

    public function inspect(ContainerId|string $container): ContainerInfo
    {
        return $this->mapper->containerInfo(
            $this->raw->request('GET', '/containers/' . $this->id($container) . '/json')->json(),
        );
    }

    public function start(ContainerId|string $container): void
    {
        $this->raw->request('POST', '/containers/' . $this->id($container) . '/start');
    }

    public function stop(ContainerId|string $container, ?int $timeoutSeconds = null): void
    {
        $this->raw->request(
            'POST',
            '/containers/' . $this->id($container) . '/stop',
            null === $timeoutSeconds ? [] : ['t' => $timeoutSeconds],
        );
    }

    public function remove(ContainerId|string $container, bool $force = false, bool $removeVolumes = false): void
    {
        $this->raw->request('DELETE', '/containers/' . $this->id($container), [
            'force' => $force,
            'v'     => $removeVolumes,
        ]);
    }

    public function logs(ContainerId|string $container, ?LogsOptions $options = null): MultiplexedStream|RawStream
    {
        $options ??= new LogsOptions();
        $query = [
            'follow'     => $options->follow,
            'stdout'     => $options->stdout,
            'stderr'     => $options->stderr,
            'timestamps' => $options->timestamps,
            'tail'       => $options->tail,
        ];

        if (null !== $options->since) {
            $query['since'] = $options->since;
        }

        if (null !== $options->until) {
            $query['until'] = $options->until;
        }

        $stream = $this->raw->stream('GET', '/containers/' . $this->id($container) . '/logs', $query)->stream;

        return $options->tty ? new RawStream($stream) : new MultiplexedStream($stream);
    }

    private function id(ContainerId|string $container): string
    {
        return rawurlencode((string) $container);
    }

    /** @return list<array<array-key, mixed>> */
    private function objects(mixed $value): array
    {
        if ( ! is_array($value)) {
            throw new InvalidResponseException('Docker returned an invalid container list.');
        }

        return array_values(array_filter($value, 'is_array'));
    }
}
