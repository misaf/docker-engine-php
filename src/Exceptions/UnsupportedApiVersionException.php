<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Exceptions;

final class UnsupportedApiVersionException extends DockerException
{
    public static function requested(string $version): self
    {
        return new self(sprintf('Docker Engine API version %s is unsupported; this SDK supports v1.40 through v1.55 inclusive.', $version));
    }

    public static function noOverlap(string $daemonMinimum, string $daemonMaximum): self
    {
        return new self(sprintf(
            'No compatible Docker Engine API version exists between SDK range 1.40-1.55 and daemon range %s-%s.',
            $daemonMinimum,
            $daemonMaximum,
        ));
    }
}
