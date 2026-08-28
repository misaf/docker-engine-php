<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Contracts;

interface HalfClosableStream extends Stream
{
    public function closeWrite(): void;
}
