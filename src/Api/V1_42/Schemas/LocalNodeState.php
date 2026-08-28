<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_42\Schemas;

/** Current local status of this node. */
enum LocalNodeState: string
{
    case Empty = '';
    case Inactive = 'inactive';
    case Pending = 'pending';
    case Active = 'active';
    case Error = 'error';
    case Locked = 'locked';
}
