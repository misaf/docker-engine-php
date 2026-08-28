<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Mapping;

use Misaf\DockerEngine\Dto\Container\ContainerInfo;
use Misaf\DockerEngine\Dto\Container\ContainerSummary;
use Misaf\DockerEngine\Dto\Image\ImageSummary;
use Misaf\DockerEngine\Dto\Network\NetworkSummary;
use Misaf\DockerEngine\Dto\System\EngineInfo;
use Misaf\DockerEngine\Dto\System\EngineVersion;
use Misaf\DockerEngine\Dto\Volume\VolumeInfo;
use Misaf\DockerEngine\Exceptions\InvalidResponseException;
use Misaf\DockerEngine\ValueObjects\ContainerId;
use Misaf\DockerEngine\ValueObjects\NetworkId;
use Misaf\DockerEngine\ValueObjects\VolumeName;

final readonly class StableResponseMapper
{
    /** @param array<array-key, mixed> $data */
    public function containerSummary(array $data): ContainerSummary
    {
        return new ContainerSummary(
            new ContainerId($this->requiredString($data, 'Id')),
            $this->stringList($data['Names'] ?? []),
            $this->string($data['Image'] ?? ''),
            $this->string($data['State'] ?? ''),
            $this->string($data['Status'] ?? ''),
            $this->stringMap($data['Labels'] ?? []),
        );
    }

    /** @param array<array-key, mixed> $data */
    public function containerInfo(array $data): ContainerInfo
    {
        $state = $this->array($data['State'] ?? []);
        $configuration = $this->stringKeyedArray($data['Config'] ?? []);
        $hostConfiguration = $this->stringKeyedArray($data['HostConfig'] ?? []);

        return new ContainerInfo(
            new ContainerId($this->requiredString($data, 'Id')),
            $this->string($data['Name'] ?? ''),
            $this->string($configuration['Image'] ?? ''),
            $this->string($state['Status'] ?? ''),
            true === ($state['Running'] ?? false),
            $configuration,
            $hostConfiguration,
        );
    }

    /** @param array<array-key, mixed> $data */
    public function imageSummary(array $data): ImageSummary
    {
        return new ImageSummary(
            $this->requiredString($data, 'Id'),
            $this->stringList($data['RepoTags'] ?? []),
            $this->stringList($data['RepoDigests'] ?? []),
            $this->integer($data['Created'] ?? 0),
            $this->integer($data['Size'] ?? 0),
        );
    }

    /** @param array<array-key, mixed> $data */
    public function networkSummary(array $data): NetworkSummary
    {
        return new NetworkSummary(
            new NetworkId($this->requiredString($data, 'Id')),
            $this->string($data['Name'] ?? ''),
            $this->string($data['Driver'] ?? ''),
            $this->string($data['Scope'] ?? ''),
            $this->stringMap($data['Labels'] ?? []),
        );
    }

    /** @param array<array-key, mixed> $data */
    public function volumeInfo(array $data): VolumeInfo
    {
        return new VolumeInfo(
            new VolumeName($this->requiredString($data, 'Name')),
            $this->string($data['Driver'] ?? ''),
            $this->string($data['Mountpoint'] ?? ''),
            $this->string($data['Scope'] ?? ''),
            $this->stringMap($data['Labels'] ?? []),
        );
    }

    /** @param array<array-key, mixed> $data */
    public function engineVersion(array $data): EngineVersion
    {
        return new EngineVersion(
            $this->string($data['Version'] ?? ''),
            $this->requiredString($data, 'ApiVersion'),
            $this->string($data['MinAPIVersion'] ?? ''),
            $this->string($data['Os'] ?? ''),
            $this->string($data['Arch'] ?? ''),
        );
    }

    /** @param array<array-key, mixed> $data */
    public function engineInfo(array $data): EngineInfo
    {
        return new EngineInfo(
            $this->string($data['ID'] ?? ''),
            $this->string($data['Name'] ?? ''),
            $this->integer($data['Containers'] ?? 0),
            $this->integer($data['ContainersRunning'] ?? 0),
            $this->integer($data['Images'] ?? 0),
            $this->string($data['OperatingSystem'] ?? ''),
            $this->string($data['Architecture'] ?? ''),
            $this->stringListMap($data['Labels'] ?? []),
        );
    }

    /** @param array<array-key, mixed> $data */
    private function requiredString(array $data, string $key): string
    {
        $value = $data[$key] ?? null;

        if ( ! is_string($value) || '' === $value) {
            throw new InvalidResponseException(sprintf('Docker response did not contain a valid %s field.', $key));
        }

        return $value;
    }

    private function string(mixed $value): string
    {
        return is_string($value) ? $value : '';
    }

    private function integer(mixed $value): int
    {
        return is_int($value) ? $value : 0;
    }

    /** @return array<array-key, mixed> */
    private function array(mixed $value): array
    {
        return is_array($value) ? $value : [];
    }

    /** @return array<string, mixed> */
    private function stringKeyedArray(mixed $value): array
    {
        if ( ! is_array($value)) {
            return [];
        }

        return array_filter($value, static fn(mixed $item, mixed $key): bool => is_string($key), ARRAY_FILTER_USE_BOTH);
    }

    /** @return list<string> */
    private function stringList(mixed $value): array
    {
        return is_array($value) ? array_values(array_filter($value, 'is_string')) : [];
    }

    /** @return array<string, string> */
    private function stringMap(mixed $value): array
    {
        if ( ! is_array($value)) {
            return [];
        }

        return array_filter($value, static fn(mixed $item, mixed $key): bool => is_string($key) && is_string($item), ARRAY_FILTER_USE_BOTH);
    }

    /** @return array<string, string> */
    private function stringListMap(mixed $value): array
    {
        $labels = [];

        foreach ($this->stringList($value) as $label) {
            [$name, $contents] = array_pad(explode('=', $label, 2), 2, '');
            $labels[$name] = $contents;
        }

        return $labels;
    }
}
