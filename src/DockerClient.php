<?php

declare(strict_types=1);

namespace Misaf\DockerEngine;

use Misaf\DockerEngine\Configuration\ClientOptions;
use Misaf\DockerEngine\Configuration\TimeoutOptions;
use Misaf\DockerEngine\Contracts\Api\ContainerApi;
use Misaf\DockerEngine\Contracts\Api\ExecApi;
use Misaf\DockerEngine\Contracts\Api\ImageApi;
use Misaf\DockerEngine\Contracts\Api\NetworkApi;
use Misaf\DockerEngine\Contracts\Api\SystemApi;
use Misaf\DockerEngine\Contracts\Api\VolumeApi;
use Misaf\DockerEngine\Contracts\Serializer;
use Misaf\DockerEngine\Contracts\Transport;
use Misaf\DockerEngine\Engine\CapabilityDetector;
use Misaf\DockerEngine\Engine\EngineCapabilities;
use Misaf\DockerEngine\Raw\RawApi;
use Misaf\DockerEngine\Resources\Containers;
use Misaf\DockerEngine\Resources\Exec;
use Misaf\DockerEngine\Resources\Images;
use Misaf\DockerEngine\Resources\Networks;
use Misaf\DockerEngine\Resources\System;
use Misaf\DockerEngine\Resources\Volumes;
use Misaf\DockerEngine\Serialization\SymfonySerializer;
use Misaf\DockerEngine\Transport\Symfony\SymfonyTransport;
use Misaf\DockerEngine\Transport\TlsOptions;

/** Stable SDK entry point with explicit access to generated APIs. */
final class DockerClient
{
    private readonly Serializer $serializer;

    private readonly ErrorMapper $errors;

    private readonly ApiVersion $version;

    private readonly VersionedApi $versioned;

    private ?RawApi $raw = null;

    private ?ContainerApi $containers = null;

    private ?ImageApi $images = null;

    private ?NetworkApi $networks = null;

    private ?VolumeApi $volumes = null;

    private ?ExecApi $exec = null;

    private ?SystemApi $system = null;

    private ?EngineCapabilities $capabilities = null;

    public function __construct(
        private readonly Transport $transport,
        ?ApiVersion $version = null,
        ?Serializer $serializer = null,
    ) {
        $this->serializer = $serializer ?? new SymfonySerializer();
        $this->errors = new ErrorMapper();
        $this->version = $version ?? new VersionNegotiator($transport, $this->errors)->negotiate();
        $this->versioned = new VersionedApi(match ($this->version) {
            ApiVersion::V1_40 => new Api\V1_40\ApiSet($transport, $this->version, $this->serializer, $this->errors),
            ApiVersion::V1_41 => new Api\V1_41\ApiSet($transport, $this->version, $this->serializer, $this->errors),
            ApiVersion::V1_42 => new Api\V1_42\ApiSet($transport, $this->version, $this->serializer, $this->errors),
            ApiVersion::V1_43 => new Api\V1_43\ApiSet($transport, $this->version, $this->serializer, $this->errors),
            ApiVersion::V1_44 => new Api\V1_44\ApiSet($transport, $this->version, $this->serializer, $this->errors),
            ApiVersion::V1_45 => new Api\V1_45\ApiSet($transport, $this->version, $this->serializer, $this->errors),
            ApiVersion::V1_46 => new Api\V1_46\ApiSet($transport, $this->version, $this->serializer, $this->errors),
            ApiVersion::V1_47 => new Api\V1_47\ApiSet($transport, $this->version, $this->serializer, $this->errors),
            ApiVersion::V1_48 => new Api\V1_48\ApiSet($transport, $this->version, $this->serializer, $this->errors),
            ApiVersion::V1_49 => new Api\V1_49\ApiSet($transport, $this->version, $this->serializer, $this->errors),
            ApiVersion::V1_50 => new Api\V1_50\ApiSet($transport, $this->version, $this->serializer, $this->errors),
            ApiVersion::V1_51 => new Api\V1_51\ApiSet($transport, $this->version, $this->serializer, $this->errors),
            ApiVersion::V1_52 => new Api\V1_52\ApiSet($transport, $this->version, $this->serializer, $this->errors),
            ApiVersion::V1_53 => new Api\V1_53\ApiSet($transport, $this->version, $this->serializer, $this->errors),
            ApiVersion::V1_54 => new Api\V1_54\ApiSet($transport, $this->version, $this->serializer, $this->errors),
            ApiVersion::V1_55 => new Api\V1_55\ApiSet($transport, $this->version, $this->serializer, $this->errors),
        });
    }

    public static function create(
        string $host = 'unix:///var/run/docker.sock',
        ?ApiVersion $version = null,
        int $timeoutSeconds = 60,
        ?TlsOptions $tls = null,
        ?Serializer $serializer = null,
    ): self {
        return self::fromOptions(ClientOptions::resolve([
            'host'        => $host,
            'api_version' => $version,
            'timeouts'    => new TimeoutOptions(request: $timeoutSeconds),
            'tls'         => $tls,
        ]), $serializer);
    }

    public static function fromOptions(ClientOptions $options, ?Serializer $serializer = null): self
    {
        $serializer ??= new SymfonySerializer();
        $transport = new SymfonyTransport($options, $serializer);

        return new self($transport, $options->apiVersion, $serializer);
    }

    public function version(): ApiVersion
    {
        return $this->version;
    }

    public function raw(): RawApi
    {
        return $this->raw ??= new RawApi($this->transport, $this->version, $this->errors);
    }

    public function versioned(): VersionedApi
    {
        return $this->versioned;
    }

    public function containers(): ContainerApi
    {
        return $this->containers ??= new Containers($this->raw());
    }

    public function images(): ImageApi
    {
        return $this->images ??= new Images($this->raw());
    }

    public function networks(): NetworkApi
    {
        return $this->networks ??= new Networks($this->raw());
    }

    public function volumes(): VolumeApi
    {
        return $this->volumes ??= new Volumes($this->raw());
    }

    public function exec(): ExecApi
    {
        return $this->exec ??= new Exec($this->raw());
    }

    public function system(): SystemApi
    {
        return $this->system ??= new System($this->raw());
    }

    /** @deprecated Use versioned()->api()->swarm(). */
    public function swarm(): Api\V1_40\Swarm\SwarmApi
    |Api\V1_41\Swarm\SwarmApi
    |Api\V1_42\Swarm\SwarmApi
    |Api\V1_43\Swarm\SwarmApi
    |Api\V1_44\Swarm\SwarmApi
    |Api\V1_45\Swarm\SwarmApi
    |Api\V1_46\Swarm\SwarmApi
    |Api\V1_47\Swarm\SwarmApi
    |Api\V1_48\Swarm\SwarmApi
    |Api\V1_49\Swarm\SwarmApi
    |Api\V1_50\Swarm\SwarmApi
    |Api\V1_51\Swarm\SwarmApi
    |Api\V1_52\Swarm\SwarmApi
    |Api\V1_53\Swarm\SwarmApi
    |Api\V1_54\Swarm\SwarmApi
    |Api\V1_55\Swarm\SwarmApi
    {
        return $this->versioned->api()->swarm();
    }

    /** @deprecated Use versioned()->api()->node(). */
    public function nodes(): Api\V1_40\Node\NodeApi
    |Api\V1_41\Node\NodeApi
    |Api\V1_42\Node\NodeApi
    |Api\V1_43\Node\NodeApi
    |Api\V1_44\Node\NodeApi
    |Api\V1_45\Node\NodeApi
    |Api\V1_46\Node\NodeApi
    |Api\V1_47\Node\NodeApi
    |Api\V1_48\Node\NodeApi
    |Api\V1_49\Node\NodeApi
    |Api\V1_50\Node\NodeApi
    |Api\V1_51\Node\NodeApi
    |Api\V1_52\Node\NodeApi
    |Api\V1_53\Node\NodeApi
    |Api\V1_54\Node\NodeApi
    |Api\V1_55\Node\NodeApi
    {
        return $this->versioned->api()->node();
    }

    /** @deprecated Use versioned()->api()->service(). */
    public function services(): Api\V1_40\Service\ServiceApi
    |Api\V1_41\Service\ServiceApi
    |Api\V1_42\Service\ServiceApi
    |Api\V1_43\Service\ServiceApi
    |Api\V1_44\Service\ServiceApi
    |Api\V1_45\Service\ServiceApi
    |Api\V1_46\Service\ServiceApi
    |Api\V1_47\Service\ServiceApi
    |Api\V1_48\Service\ServiceApi
    |Api\V1_49\Service\ServiceApi
    |Api\V1_50\Service\ServiceApi
    |Api\V1_51\Service\ServiceApi
    |Api\V1_52\Service\ServiceApi
    |Api\V1_53\Service\ServiceApi
    |Api\V1_54\Service\ServiceApi
    |Api\V1_55\Service\ServiceApi
    {
        return $this->versioned->api()->service();
    }

    /** @deprecated Use versioned()->api()->task(). */
    public function tasks(): Api\V1_40\Task\TaskApi
    |Api\V1_41\Task\TaskApi
    |Api\V1_42\Task\TaskApi
    |Api\V1_43\Task\TaskApi
    |Api\V1_44\Task\TaskApi
    |Api\V1_45\Task\TaskApi
    |Api\V1_46\Task\TaskApi
    |Api\V1_47\Task\TaskApi
    |Api\V1_48\Task\TaskApi
    |Api\V1_49\Task\TaskApi
    |Api\V1_50\Task\TaskApi
    |Api\V1_51\Task\TaskApi
    |Api\V1_52\Task\TaskApi
    |Api\V1_53\Task\TaskApi
    |Api\V1_54\Task\TaskApi
    |Api\V1_55\Task\TaskApi
    {
        return $this->versioned->api()->task();
    }

    /** @deprecated Use versioned()->api()->secret(). */
    public function secrets(): Api\V1_40\Secret\SecretApi
    |Api\V1_41\Secret\SecretApi
    |Api\V1_42\Secret\SecretApi
    |Api\V1_43\Secret\SecretApi
    |Api\V1_44\Secret\SecretApi
    |Api\V1_45\Secret\SecretApi
    |Api\V1_46\Secret\SecretApi
    |Api\V1_47\Secret\SecretApi
    |Api\V1_48\Secret\SecretApi
    |Api\V1_49\Secret\SecretApi
    |Api\V1_50\Secret\SecretApi
    |Api\V1_51\Secret\SecretApi
    |Api\V1_52\Secret\SecretApi
    |Api\V1_53\Secret\SecretApi
    |Api\V1_54\Secret\SecretApi
    |Api\V1_55\Secret\SecretApi
    {
        return $this->versioned->api()->secret();
    }

    /** @deprecated Use versioned()->api()->config(). */
    public function configs(): Api\V1_40\Config\ConfigApi
    |Api\V1_41\Config\ConfigApi
    |Api\V1_42\Config\ConfigApi
    |Api\V1_43\Config\ConfigApi
    |Api\V1_44\Config\ConfigApi
    |Api\V1_45\Config\ConfigApi
    |Api\V1_46\Config\ConfigApi
    |Api\V1_47\Config\ConfigApi
    |Api\V1_48\Config\ConfigApi
    |Api\V1_49\Config\ConfigApi
    |Api\V1_50\Config\ConfigApi
    |Api\V1_51\Config\ConfigApi
    |Api\V1_52\Config\ConfigApi
    |Api\V1_53\Config\ConfigApi
    |Api\V1_54\Config\ConfigApi
    |Api\V1_55\Config\ConfigApi
    {
        return $this->versioned->api()->config();
    }

    /** @deprecated Use versioned()->api()->plugin(). */
    public function plugins(): Api\V1_40\Plugin\PluginApi
    |Api\V1_41\Plugin\PluginApi
    |Api\V1_42\Plugin\PluginApi
    |Api\V1_43\Plugin\PluginApi
    |Api\V1_44\Plugin\PluginApi
    |Api\V1_45\Plugin\PluginApi
    |Api\V1_46\Plugin\PluginApi
    |Api\V1_47\Plugin\PluginApi
    |Api\V1_48\Plugin\PluginApi
    |Api\V1_49\Plugin\PluginApi
    |Api\V1_50\Plugin\PluginApi
    |Api\V1_51\Plugin\PluginApi
    |Api\V1_52\Plugin\PluginApi
    |Api\V1_53\Plugin\PluginApi
    |Api\V1_54\Plugin\PluginApi
    |Api\V1_55\Plugin\PluginApi
    {
        return $this->versioned->api()->plugin();
    }

    /** @deprecated Use versioned()->api()->distribution(). */
    public function distribution(): Api\V1_40\Distribution\DistributionApi
    |Api\V1_41\Distribution\DistributionApi
    |Api\V1_42\Distribution\DistributionApi
    |Api\V1_43\Distribution\DistributionApi
    |Api\V1_44\Distribution\DistributionApi
    |Api\V1_45\Distribution\DistributionApi
    |Api\V1_46\Distribution\DistributionApi
    |Api\V1_47\Distribution\DistributionApi
    |Api\V1_48\Distribution\DistributionApi
    |Api\V1_49\Distribution\DistributionApi
    |Api\V1_50\Distribution\DistributionApi
    |Api\V1_51\Distribution\DistributionApi
    |Api\V1_52\Distribution\DistributionApi
    |Api\V1_53\Distribution\DistributionApi
    |Api\V1_54\Distribution\DistributionApi
    |Api\V1_55\Distribution\DistributionApi
    {
        return $this->versioned->api()->distribution();
    }

    /** @deprecated Use versioned()->api()->session(). */
    public function session(): Api\V1_40\Session\SessionApi
    |Api\V1_41\Session\SessionApi
    |Api\V1_42\Session\SessionApi
    |Api\V1_43\Session\SessionApi
    |Api\V1_44\Session\SessionApi
    |Api\V1_45\Session\SessionApi
    |Api\V1_46\Session\SessionApi
    |Api\V1_47\Session\SessionApi
    |Api\V1_48\Session\SessionApi
    |Api\V1_49\Session\SessionApi
    |Api\V1_50\Session\SessionApi
    |Api\V1_51\Session\SessionApi
    |Api\V1_52\Session\SessionApi
    |Api\V1_53\Session\SessionApi
    |Api\V1_54\Session\SessionApi
    |Api\V1_55\Session\SessionApi
    {
        return $this->versioned->api()->session();
    }

    public function capabilities(): EngineCapabilities
    {
        return $this->capabilities ??= new CapabilityDetector($this->raw(), $this->version)->detect();
    }
}
