<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Exec;

use Misaf\DockerEngine\Contracts\Stream;
use Misaf\DockerEngine\Streaming\MultiplexedStream;
use Misaf\DockerEngine\Streaming\RawStream;
use Misaf\DockerEngine\ValueObjects\ExecId;

final readonly class ExecSession
{
    public function __construct(
        public ExecId $execId,
        private Stream $stream,
        public bool $tty,
    ) {}

    public function write(string $stdin): int
    {
        return $this->stream->write($stdin);
    }

    public function consume(callable $onStdout, ?callable $onStderr = null): void
    {
        if ($this->tty) {
            foreach ((new RawStream($this->stream))->chunks() as $chunk) {
                $onStdout($chunk);
            }

            return;
        }

        (new MultiplexedStream($this->stream))->consume($onStdout, $onStderr);
    }

    public function close(): void
    {
        $this->stream->close();
    }
}
