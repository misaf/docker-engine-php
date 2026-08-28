<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Streaming;

use Generator;
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
        yield from $this->decoder->decode($this->stream);
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
}
