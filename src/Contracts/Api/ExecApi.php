<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Contracts\Api;

use Misaf\DockerEngine\Exec\ExecResult;
use Misaf\DockerEngine\Exec\ExecRunOptions;
use Misaf\DockerEngine\Exec\ExecSession;
use Misaf\DockerEngine\ValueObjects\ContainerId;
use Misaf\DockerEngine\ValueObjects\ExecId;

interface ExecApi
{
    /** @param list<string> $command */
    public function run(ContainerId|string $container, array $command, ?ExecRunOptions $options = null): ExecResult;

    public function stream(ExecId|string $exec, bool $tty = false): ExecSession;
}
