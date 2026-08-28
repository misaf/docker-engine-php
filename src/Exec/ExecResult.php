<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Exec;

use Misaf\DockerEngine\ValueObjects\ExecId;

final readonly class ExecResult
{
    public function __construct(
        public ExecId $execId,
        public int $exitCode,
        public string $stdout,
        public ?string $stderr,
        public bool $tty,
    ) {}

    public function successful(): bool
    {
        return 0 === $this->exitCode;
    }
}
