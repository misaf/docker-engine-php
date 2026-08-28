<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\ValueObjects;

use InvalidArgumentException;
use Stringable;

final readonly class NetworkId implements Stringable
{
    public function __construct(public string $value)
    {
        if ('' === mb_trim($value)) {
            throw new InvalidArgumentException('Network ID or name cannot be empty.');
        }
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
