<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Dto\Container;

final readonly class LogsOptions
{
    public function __construct(
        public bool $follow = false,
        public bool $stdout = true,
        public bool $stderr = true,
        public ?int $since = null,
        public ?int $until = null,
        public bool $timestamps = false,
        public string $tail = 'all',
        public bool $tty = false,
    ) {}
}
