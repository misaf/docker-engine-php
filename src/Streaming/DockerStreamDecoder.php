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
            while (mb_strlen($buffer, '8bit') < 8 && ! $stream->eof()) {
                $buffer .= $stream->read();
            }

            if ('' === $buffer) {
                return;
            }

            if (mb_strlen($buffer, '8bit') < 8) {
                throw new InvalidResponseException('Docker multiplexed stream ended inside a frame header.');
            }

            $type = StreamType::tryFrom(ord($buffer[0]));

            if (null === $type || "\0\0\0" !== mb_substr($buffer, 1, 3, '8bit')) {
                throw new InvalidResponseException('Docker multiplexed stream contains an invalid frame header.');
            }

            /** @var array{length: int} $length */
            $length = unpack('Nlength', mb_substr($buffer, 4, 4, '8bit'));
            $required = 8 + $length['length'];

            while (mb_strlen($buffer, '8bit') < $required && ! $stream->eof()) {
                $buffer .= $stream->read(max(8192, $required - mb_strlen($buffer, '8bit')));
            }

            if (mb_strlen($buffer, '8bit') < $required) {
                throw new InvalidResponseException('Docker multiplexed stream ended inside a frame payload.');
            }

            yield new StreamFrame($type, mb_substr($buffer, 8, $length['length'], '8bit'));
            $buffer = mb_substr($buffer, $required, null, '8bit');
        }
    }
}
