<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Engine;

enum EngineImplementation: string
{
    case Docker = 'docker';
    case Podman = 'podman';
    case Unknown = 'unknown';
}
