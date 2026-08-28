<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Streaming;

use Generator;
use Misaf\DockerEngine\Contracts\CancellableStream;
use Misaf\DockerEngine\Contracts\Stream;

final readonly class MultiplexedStream
{
    public function __construct(
        private Stream $stream,
        private DockerStreamDecoder $decoder = new DockerStreamDecoder(),
    ) {}

    /** @return Generator<int, StreamFrame> */
    public function frames(): Generator
    {
        try {
            yield from $this->decoder->decode($this->stream);
        } finally {
            $this->stream->close();
        }
    }

    public function consume(?callable $onStdout = null, ?callable $onStderr = null): void
    {
        foreach ($this->frames() as $frame) {
            if (StreamType::Stdout === $frame->type) {
                if (null !== $onStdout) {
                    $onStdout($frame->payload);
                }
            } elseif (StreamType::Stderr === $frame->type) {
                if (null !== $onStderr) {
                    $onStderr($frame->payload);
                }
            }
        }
    }

    public function close(): void
    {
        $this->stream->close();
    }

    public function cancel(): void
    {
        if ($this->stream instanceof CancellableStream) {
            $this->stream->cancel();

            return;
        }

        $this->stream->close();
    }
}
