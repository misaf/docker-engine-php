<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Exceptions;

use Throwable;

class TransportException extends DockerException
{
    public static function connection(string $endpoint, string $reason, ?Throwable $previous = null): self
    {
        return new self(sprintf('Docker transport to %s failed: %s', $endpoint, $reason), previous: $previous);
    }
}
