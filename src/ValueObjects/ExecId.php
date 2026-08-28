<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\ValueObjects;

use InvalidArgumentException;
use Stringable;

final readonly class ExecId implements Stringable
{
    public function __construct(public string $value)
    {
        if ('' === mb_trim($value)) {
            throw new InvalidArgumentException('Exec ID cannot be empty.');
        }
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
