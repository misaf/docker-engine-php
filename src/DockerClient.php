<?php

declare(strict_types=1);

namespace Misaf\DockerEngine;

use Misaf\DockerEngine\Configuration\ClientOptions;
use Misaf\DockerEngine\Configuration\TimeoutOptions;
use Misaf\DockerEngine\Contracts\Serializer;
use Misaf\DockerEngine\Contracts\Transport;
use Misaf\DockerEngine\Raw\RawApi;
use Misaf\DockerEngine\Serialization\SymfonySerializer;
use Misaf\DockerEngine\Transport\SymfonyTransport;
use Misaf\DockerEngine\Transport\TlsOptions;

/** Public, client-level version selector for the generated Engine APIs. */
final class DockerClient
{
    private readonly \Misaf\DockerEngine\Api\V1_40\ApiSet
        |\Misaf\DockerEngine\Api\V1_41\ApiSet
        |\Misaf\DockerEngine\Api\V1_42\ApiSet
        |\Misaf\DockerEngine\Api\V1_43\ApiSet
        |\Misaf\DockerEngine\Api\V1_44\ApiSet
        |\Misaf\DockerEngine\Api\V1_45\ApiSet
        |\Misaf\DockerEngine\Api\V1_46\ApiSet
        |\Misaf\DockerEngine\Api\V1_47\ApiSet
        |\Misaf\DockerEngine\Api\V1_48\ApiSet
        |\Misaf\DockerEngine\Api\V1_49\ApiSet
        |\Misaf\DockerEngine\Api\V1_50\ApiSet
        |\Misaf\DockerEngine\Api\V1_51\ApiSet
        |\Misaf\DockerEngine\Api\V1_52\ApiSet
        |\Misaf\DockerEngine\Api\V1_53\ApiSet
        |\Misaf\DockerEngine\Api\V1_54\ApiSet
        |Api\V1_55\ApiSet $apis;

    private readonly Serializer $serializer;

    private readonly ErrorMapper $errors;

    private readonly ApiVersion $version;

    private ?RawApi $raw = null;

    public function __construct(
        private readonly Transport $transport,
        ?ApiVersion $version = null,
        ?Serializer $serializer = null,
    ) {
        $this->serializer = $serializer ?? new SymfonySerializer();
        $this->errors = new ErrorMapper();
        $this->version = $version ?? new VersionNegotiator($transport, $this->errors)->negotiate();
        $this->apis = match ($this->version) {
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
        };
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

    public function containers(): Api\V1_40\Container\ContainerApi
    |Api\V1_41\Container\ContainerApi
    |Api\V1_42\Container\ContainerApi
    |Api\V1_43\Container\ContainerApi
    |Api\V1_44\Container\ContainerApi
    |Api\V1_45\Container\ContainerApi
    |Api\V1_46\Container\ContainerApi
    |Api\V1_47\Container\ContainerApi
    |Api\V1_48\Container\ContainerApi
    |Api\V1_49\Container\ContainerApi
    |Api\V1_50\Container\ContainerApi
    |Api\V1_51\Container\ContainerApi
    |Api\V1_52\Container\ContainerApi
    |Api\V1_53\Container\ContainerApi
    |Api\V1_54\Container\ContainerApi
    |Api\V1_55\Container\ContainerApi
    {
        return $this->apis->container();
    }

    public function images(): Api\V1_40\Image\ImageApi
    |Api\V1_41\Image\ImageApi
    |Api\V1_42\Image\ImageApi
    |Api\V1_43\Image\ImageApi
    |Api\V1_44\Image\ImageApi
    |Api\V1_45\Image\ImageApi
    |Api\V1_46\Image\ImageApi
    |Api\V1_47\Image\ImageApi
    |Api\V1_48\Image\ImageApi
    |Api\V1_49\Image\ImageApi
    |Api\V1_50\Image\ImageApi
    |Api\V1_51\Image\ImageApi
    |Api\V1_52\Image\ImageApi
    |Api\V1_53\Image\ImageApi
    |Api\V1_54\Image\ImageApi
    |Api\V1_55\Image\ImageApi
    {
        return $this->apis->image();
    }

    public function networks(): Api\V1_40\Network\NetworkApi
    |Api\V1_41\Network\NetworkApi
    |Api\V1_42\Network\NetworkApi
    |Api\V1_43\Network\NetworkApi
    |Api\V1_44\Network\NetworkApi
    |Api\V1_45\Network\NetworkApi
    |Api\V1_46\Network\NetworkApi
    |Api\V1_47\Network\NetworkApi
    |Api\V1_48\Network\NetworkApi
    |Api\V1_49\Network\NetworkApi
    |Api\V1_50\Network\NetworkApi
    |Api\V1_51\Network\NetworkApi
    |Api\V1_52\Network\NetworkApi
    |Api\V1_53\Network\NetworkApi
    |Api\V1_54\Network\NetworkApi
    |Api\V1_55\Network\NetworkApi
    {
        return $this->apis->network();
    }

    public function volumes(): Api\V1_40\Volume\VolumeApi
    |Api\V1_41\Volume\VolumeApi
    |Api\V1_42\Volume\VolumeApi
    |Api\V1_43\Volume\VolumeApi
    |Api\V1_44\Volume\VolumeApi
    |Api\V1_45\Volume\VolumeApi
    |Api\V1_46\Volume\VolumeApi
    |Api\V1_47\Volume\VolumeApi
    |Api\V1_48\Volume\VolumeApi
    |Api\V1_49\Volume\VolumeApi
    |Api\V1_50\Volume\VolumeApi
    |Api\V1_51\Volume\VolumeApi
    |Api\V1_52\Volume\VolumeApi
    |Api\V1_53\Volume\VolumeApi
    |Api\V1_54\Volume\VolumeApi
    |Api\V1_55\Volume\VolumeApi
    {
        return $this->apis->volume();
    }

    public function exec(): Api\V1_40\Exec\ExecApi
    |Api\V1_41\Exec\ExecApi
    |Api\V1_42\Exec\ExecApi
    |Api\V1_43\Exec\ExecApi
    |Api\V1_44\Exec\ExecApi
    |Api\V1_45\Exec\ExecApi
    |Api\V1_46\Exec\ExecApi
    |Api\V1_47\Exec\ExecApi
    |Api\V1_48\Exec\ExecApi
    |Api\V1_49\Exec\ExecApi
    |Api\V1_50\Exec\ExecApi
    |Api\V1_51\Exec\ExecApi
    |Api\V1_52\Exec\ExecApi
    |Api\V1_53\Exec\ExecApi
    |Api\V1_54\Exec\ExecApi
    |Api\V1_55\Exec\ExecApi
    {
        return $this->apis->exec();
    }

    public function system(): Api\V1_40\System\SystemApi
    |Api\V1_41\System\SystemApi
    |Api\V1_42\System\SystemApi
    |Api\V1_43\System\SystemApi
    |Api\V1_44\System\SystemApi
    |Api\V1_45\System\SystemApi
    |Api\V1_46\System\SystemApi
    |Api\V1_47\System\SystemApi
    |Api\V1_48\System\SystemApi
    |Api\V1_49\System\SystemApi
    |Api\V1_50\System\SystemApi
    |Api\V1_51\System\SystemApi
    |Api\V1_52\System\SystemApi
    |Api\V1_53\System\SystemApi
    |Api\V1_54\System\SystemApi
    |Api\V1_55\System\SystemApi
    {
        return $this->apis->system();
    }

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
        return $this->apis->swarm();
    }

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
        return $this->apis->node();
    }

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
        return $this->apis->service();
    }

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
        return $this->apis->task();
    }

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
        return $this->apis->secret();
    }

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
        return $this->apis->config();
    }

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
        return $this->apis->plugin();
    }

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
        return $this->apis->distribution();
    }

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
        return $this->apis->session();
    }
}
