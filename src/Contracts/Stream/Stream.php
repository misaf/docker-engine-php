<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Contracts\Stream;

interface Stream
{
    public function read(int $length = 8192): string;

    public function write(string $data): int;

    public function eof(): bool;

    public function close(): void;
}
