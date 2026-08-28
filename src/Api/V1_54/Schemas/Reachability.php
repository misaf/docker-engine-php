<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_54\Schemas;

/** Reachability represents the reachability of a node. */
enum Reachability: string
{
    case Unknown = 'unknown';
    case Unreachable = 'unreachable';
    case Reachable = 'reachable';
}
