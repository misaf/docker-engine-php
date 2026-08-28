<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Symfony config tree for the Docker Engine client.
 *
 * Mirrors the keys accepted by ClientOptions so the same shape works in
 * config/packages/docker_engine.yaml or any array passed to DockerClient::fromArray().
 */
final class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('docker_engine');
        $root = $treeBuilder->getRootNode();

        $root
            ->children()
            ->scalarNode('host')
            ->defaultValue('unix:///var/run/docker.sock')
            ->info('Engine host: unix://, tcp://, http://, or https://.')
            ->end()
            ->scalarNode('api_version')
            ->defaultNull()
            ->info('Pin the Engine API version, e.g. "1.55". Null negotiates.')
            ->end()
            ->arrayNode('timeouts')
            ->addDefaultsIfNotSet()
            ->children()
            ->floatNode('connect')->defaultValue(5.0)->end()
            ->floatNode('request')->defaultValue(60.0)->end()
            ->floatNode('stream_idle')->defaultNull()->end()
            ->end()
            ->end()
            ->arrayNode('tls')
            ->children()
            ->scalarNode('ca')->defaultNull()->end()
            ->scalarNode('certificate')->defaultNull()->end()
            ->scalarNode('private_key')->defaultNull()->end()
            ->scalarNode('private_key_password')->defaultNull()->end()
            ->booleanNode('verify_peer')->defaultTrue()->end()
            ->booleanNode('verify_host')->defaultTrue()->end()
            ->end()
            ->end()
            ->arrayNode('headers')
            ->normalizeKeys(false)
            ->variablePrototype()
            ->end()
            ->end()
            ->end();

        return $treeBuilder;
    }
}
