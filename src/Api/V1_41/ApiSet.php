<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_41;

use Misaf\DockerEngine\ApiVersion;
use Misaf\DockerEngine\Contracts\Serializer;
use Misaf\DockerEngine\Contracts\Transport;
use Misaf\DockerEngine\ErrorMapper;

final class ApiSet
{
    private ?Config\ConfigApi $config = null;
    private ?Container\ContainerApi $container = null;
    private ?Distribution\DistributionApi $distribution = null;
    private ?Exec\ExecApi $exec = null;
    private ?Image\ImageApi $image = null;
    private ?Network\NetworkApi $network = null;
    private ?Node\NodeApi $node = null;
    private ?Plugin\PluginApi $plugin = null;
    private ?Secret\SecretApi $secret = null;
    private ?Service\ServiceApi $service = null;
    private ?Session\SessionApi $session = null;
    private ?Swarm\SwarmApi $swarm = null;
    private ?System\SystemApi $system = null;
    private ?Task\TaskApi $task = null;
    private ?Volume\VolumeApi $volume = null;

    public function __construct(
        private readonly Transport $transport,
        private readonly ApiVersion $version,
        private readonly Serializer $serializer,
        private readonly ErrorMapper $errors,
    ) {}

    public function config(): Config\ConfigApi
    {
        return $this->config ??= new Config\ConfigApi(
            $this->transport,
            $this->version,
            $this->serializer,
            $this->errors,
        );
    }

    public function container(): Container\ContainerApi
    {
        return $this->container ??= new Container\ContainerApi(
            $this->transport,
            $this->version,
            $this->serializer,
            $this->errors,
        );
    }

    public function distribution(): Distribution\DistributionApi
    {
        return $this->distribution ??= new Distribution\DistributionApi(
            $this->transport,
            $this->version,
            $this->serializer,
            $this->errors,
        );
    }

    public function exec(): Exec\ExecApi
    {
        return $this->exec ??= new Exec\ExecApi(
            $this->transport,
            $this->version,
            $this->serializer,
            $this->errors,
        );
    }

    public function image(): Image\ImageApi
    {
        return $this->image ??= new Image\ImageApi(
            $this->transport,
            $this->version,
            $this->serializer,
            $this->errors,
        );
    }

    public function network(): Network\NetworkApi
    {
        return $this->network ??= new Network\NetworkApi(
            $this->transport,
            $this->version,
            $this->serializer,
            $this->errors,
        );
    }

    public function node(): Node\NodeApi
    {
        return $this->node ??= new Node\NodeApi(
            $this->transport,
            $this->version,
            $this->serializer,
            $this->errors,
        );
    }

    public function plugin(): Plugin\PluginApi
    {
        return $this->plugin ??= new Plugin\PluginApi(
            $this->transport,
            $this->version,
            $this->serializer,
            $this->errors,
        );
    }

    public function secret(): Secret\SecretApi
    {
        return $this->secret ??= new Secret\SecretApi(
            $this->transport,
            $this->version,
            $this->serializer,
            $this->errors,
        );
    }

    public function service(): Service\ServiceApi
    {
        return $this->service ??= new Service\ServiceApi(
            $this->transport,
            $this->version,
            $this->serializer,
            $this->errors,
        );
    }

    public function session(): Session\SessionApi
    {
        return $this->session ??= new Session\SessionApi(
            $this->transport,
            $this->version,
            $this->serializer,
            $this->errors,
        );
    }

    public function swarm(): Swarm\SwarmApi
    {
        return $this->swarm ??= new Swarm\SwarmApi(
            $this->transport,
            $this->version,
            $this->serializer,
            $this->errors,
        );
    }

    public function system(): System\SystemApi
    {
        return $this->system ??= new System\SystemApi(
            $this->transport,
            $this->version,
            $this->serializer,
            $this->errors,
        );
    }

    public function task(): Task\TaskApi
    {
        return $this->task ??= new Task\TaskApi(
            $this->transport,
            $this->version,
            $this->serializer,
            $this->errors,
        );
    }

    public function volume(): Volume\VolumeApi
    {
        return $this->volume ??= new Volume\VolumeApi(
            $this->transport,
            $this->version,
            $this->serializer,
            $this->errors,
        );
    }
}
