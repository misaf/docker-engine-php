<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Streaming;

use Generator;
use Misaf\DockerEngine\Contracts\Stream;
use Misaf\DockerEngine\Exceptions\InvalidResponseException;

final class DockerStreamDecoder
{
    /** @return Generator<int, StreamFrame> */
    public function decode(Stream $stream): Generator
    {
        $buffer = '';

        while ( ! $stream->eof() || '' !== $buffer) {
            while (mb_strlen($buffer) < 8 && ! $stream->eof()) {
                $buffer .= $stream->read();
            }

            if ('' === $buffer) {
                return;
            }

            if (mb_strlen($buffer) < 8) {
                throw new InvalidResponseException('Docker multiplexed stream ended inside a frame header.');
            }

            $type = StreamType::tryFrom(ord($buffer[0]));

            if (null === $type || "\0\0\0" !== mb_substr($buffer, 1, 3)) {
                throw new InvalidResponseException('Docker multiplexed stream contains an invalid frame header.');
            }

            /** @var array{length: int} $length */
            $length = unpack('Nlength', mb_substr($buffer, 4, 4));
            $required = 8 + $length['length'];

            while (mb_strlen($buffer) < $required && ! $stream->eof()) {
                $buffer .= $stream->read(max(8192, $required - mb_strlen($buffer)));
            }

            if (mb_strlen($buffer) < $required) {
                throw new InvalidResponseException('Docker multiplexed stream ended inside a frame payload.');
            }

            yield new StreamFrame($type, mb_substr($buffer, 8, $length['length']));
            $buffer = mb_substr($buffer, $required);
        }
    }
}
