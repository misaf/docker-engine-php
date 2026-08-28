<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_55\Schemas;

/** The mount type. Available types: */
enum MountType: string
{
    case Bind = 'bind';
    case Cluster = 'cluster';
    case Image = 'image';
    case Npipe = 'npipe';
    case Tmpfs = 'tmpfs';
    case Volume = 'volume';
}
