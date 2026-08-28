<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Contracts;

use Misaf\DockerEngine\Dto\Container\ContainerInfo;
use Misaf\DockerEngine\Dto\Container\ContainerSummary;
use Misaf\DockerEngine\Dto\Container\CreateContainer;
use Misaf\DockerEngine\Dto\Container\CreatedContainer;
use Misaf\DockerEngine\Dto\Container\ListContainers;
use Misaf\DockerEngine\Dto\Container\LogsOptions;
use Misaf\DockerEngine\Streaming\MultiplexedStream;
use Misaf\DockerEngine\Streaming\RawStream;
use Misaf\DockerEngine\ValueObjects\ContainerId;

interface ContainerApi
{
    /** @return list<ContainerSummary> */
    public function list(?ListContainers $options = null): array;

    public function create(CreateContainer $request): CreatedContainer;

    public function inspect(ContainerId|string $container): ContainerInfo;

    public function start(ContainerId|string $container): void;

    public function stop(ContainerId|string $container, ?int $timeoutSeconds = null): void;

    public function remove(ContainerId|string $container, bool $force = false, bool $removeVolumes = false): void;

    public function logs(ContainerId|string $container, ?LogsOptions $options = null): MultiplexedStream|RawStream;
}
