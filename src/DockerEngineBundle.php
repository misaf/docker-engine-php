<?php

declare(strict_types=1);

namespace Misaf\DockerEngine;

use Misaf\DockerEngine\DependencyInjection\DockerEngineExtension;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * Symfony bundle that wires DockerClient from config/packages/docker_engine.yaml.
 */
final class DockerEngineBundle extends Bundle
{
    public function getContainerExtension(): ExtensionInterface
    {
        return new DockerEngineExtension();
    }
}
