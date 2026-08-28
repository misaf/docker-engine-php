<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Configuration;

use InvalidArgumentException;

final readonly class TimeoutOptions
{
    public function __construct(
        public float $connect = 5.0,
        public float $request = 60.0,
        public ?float $streamIdle = null,
    ) {
        if ($this->connect <= 0) {
            throw new InvalidArgumentException('The connect timeout must be greater than zero.');
        }

        if ($this->request <= 0) {
            throw new InvalidArgumentException('The request timeout must be greater than zero.');
        }

        if (null !== $this->streamIdle && $this->streamIdle <= 0) {
            throw new InvalidArgumentException('The stream idle timeout must be greater than zero or null.');
        }
    }
}
