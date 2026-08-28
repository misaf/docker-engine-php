<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Streaming;

enum StreamType: int
{
    case Stdin = 0;
    case Stdout = 1;
    case Stderr = 2;
}
