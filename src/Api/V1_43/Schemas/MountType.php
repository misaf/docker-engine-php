<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_43\Schemas;

/** The mount type. Available types: */
enum MountType: string
{
    case Bind = 'bind';
    case Cluster = 'cluster';
    case Npipe = 'npipe';
    case Tmpfs = 'tmpfs';
    case Volume = 'volume';
}
