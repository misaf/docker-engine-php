<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Streaming;

use Generator;
use Misaf\DockerEngine\Contracts\CancellableStream;
use Misaf\DockerEngine\Contracts\Stream;

final readonly class RawStream
{
    public function __construct(private Stream $stream) {}

    /** @return Generator<int, string> */
    public function chunks(int $length = 8192): Generator
    {
        try {
            while ( ! $this->stream->eof()) {
                $chunk = $this->stream->read($length);

                if ('' !== $chunk) {
                    yield $chunk;
                }
            }
        } finally {
            $this->stream->close();
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
