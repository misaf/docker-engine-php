<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_53\Schemas;

/** Kind of change */
enum ChangeType: int
{
    case Schema0 = 0;
    case Schema1 = 1;
    case Schema2 = 2;
}
