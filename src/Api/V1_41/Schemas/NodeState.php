<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_41\Schemas;

/** NodeState represents the state of a node. */
enum NodeState: string
{
    case Unknown = 'unknown';
    case Down = 'down';
    case Ready = 'ready';
    case Disconnected = 'disconnected';
}
