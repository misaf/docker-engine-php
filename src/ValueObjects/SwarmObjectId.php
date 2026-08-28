<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\ValueObjects;

use InvalidArgumentException;
use Stringable;

abstract readonly class SwarmObjectId implements Stringable
{
    public function __construct(public string $value)
    {
        if ('' === mb_trim($value)) {
            throw new InvalidArgumentException(static::class . ' cannot be empty.');
        }
    }

    final public function __toString(): string
    {
        return $this->value;
    }
}
