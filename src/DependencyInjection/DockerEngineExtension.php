<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\DependencyInjection;

use Misaf\DockerEngine\DockerClient;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;

/**
 * Registers the DockerClient as a service built from the docker_engine config tree.
 */
final class DockerEngineExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container): void
    {
        $config = $this->processConfiguration(new Configuration(), $configs);

        $container
            ->register(DockerClient::class, DockerClient::class)
            ->setPublic(true)
            ->setFactory([DockerClient::class, 'fromArray'])
            ->setArguments([$config]);
    }

    public function getAlias(): string
    {
        return 'docker_engine';
    }
}
