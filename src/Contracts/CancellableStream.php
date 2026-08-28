<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Contracts;

interface CancellableStream extends Stream
{
    public function cancel(): void;
}
