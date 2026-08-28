<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Streaming;

use Generator;
use Misaf\DockerEngine\Contracts\Stream;

final readonly class RawStream
{
    public function __construct(private Stream $stream) {}

    /** @return Generator<int, string> */
    public function chunks(int $length = 8192): Generator
    {
        while (! $this->stream->eof()) {
            $chunk = $this->stream->read($length);

            if ('' !== $chunk) {
                yield $chunk;
            }
        }
    }
}
