<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Engine;

use Misaf\DockerEngine\ApiVersion;
use Misaf\DockerEngine\Raw\RawApi;

final readonly class CapabilityDetector
{
    public function __construct(private RawApi $raw, private ApiVersion $apiVersion) {}

    public function detect(): EngineCapabilities
    {
        $version = $this->raw->request('GET', '/version', versioned: false)->json();
        $info = $this->raw->request('GET', '/info')->json();
        $implementation = $this->implementation($version, $info);
        $docker = EngineImplementation::Docker === $implementation;

        return new EngineCapabilities(
            implementation: $implementation,
            apiVersion: $this->apiVersion,
            supportsSwarm: $docker && isset($info['Swarm']),
            supportsCheckpoint: $docker && true === ($info['ExperimentalBuild'] ?? false),
            supportsExecResize: EngineImplementation::Unknown !== $implementation
                && $this->apiVersion->isAtLeast(ApiVersion::V1_40),
            supportsSession: $docker,
            supportsPlugins: $docker && isset($info['Plugins']),
        );
    }

    /**
     * @param array<array-key, mixed> $version
     * @param array<array-key, mixed> $info
     */
    private function implementation(array $version, array $info): EngineImplementation
    {
        $platform = $version['Platform'] ?? [];
        $signals = [
            $version['Version'] ?? null,
            is_array($platform) ? ($platform['Name'] ?? null) : null,
            $info['OperatingSystem'] ?? null,
        ];

        foreach ($signals as $signal) {
            if (is_string($signal) && str_contains(mb_strtolower($signal), 'podman')) {
                return EngineImplementation::Podman;
            }
        }

        if (isset($version['ApiVersion'], $info['ServerVersion'])) {
            return EngineImplementation::Docker;
        }

        return EngineImplementation::Unknown;
    }
}
