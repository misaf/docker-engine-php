<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Transport\Socket;

use Misaf\DockerEngine\Contracts\Stream\Stream;
use Misaf\DockerEngine\Exceptions\InvalidResponseException;

/** RFC 6455 framing used by Docker's container attach WebSocket endpoint. */
final class WebSocketStream implements Stream
{
    private string $buffer = '';

    private bool $closed = false;

    public function __construct(private readonly Stream $inner) {}

    public function read(int $length = 8192): string
    {
        $length = max(1, $length);

        while ('' === $this->buffer && ! $this->closed && ! $this->inner->eof()) {
            $this->receiveFrame();
        }

        $chunk = mb_substr($this->buffer, 0, $length, '8bit');
        $this->buffer = mb_substr($this->buffer, mb_strlen($chunk, '8bit'), null, '8bit');

        return $chunk;
    }

    public function write(string $data): int
    {
        if ($this->closed) {
            throw new InvalidResponseException('Cannot write to a closed Docker WebSocket stream.');
        }

        $this->writeFrame(0x2, $data);

        return mb_strlen($data, '8bit');
    }

    public function eof(): bool
    {
        return '' === $this->buffer && ($this->closed || $this->inner->eof());
    }

    public function close(): void
    {
        if ( ! $this->closed && ! $this->inner->eof()) {
            $this->writeFrame(0x8, '');
        }

        $this->closed = true;
        $this->inner->close();
    }

    private function receiveFrame(): void
    {
        $header = $this->readExact(2);
        $first = ord($header[0]);
        $second = ord($header[1]);

        if (0 !== ($first & 0x70)) {
            throw new InvalidResponseException('Docker WebSocket frame uses unsupported reserved bits.');
        }

        $opcode = $first & 0x0f;
        $masked = 0 !== ($second & 0x80);
        $length = $second & 0x7f;

        if (126 === $length) {
            $extended = $this->readExact(2);
            $length = (ord($extended[0]) << 8) | ord($extended[1]);
        } elseif (127 === $length) {
            $extended = $this->readExact(8);
            $length = 0;

            for ($index = 0; $index < 8; $index++) {
                $byte = ord($extended[$index]);

                if ($length > intdiv(PHP_INT_MAX - $byte, 256)) {
                    throw new InvalidResponseException('Docker WebSocket frame is too large for this platform.');
                }

                $length = ($length * 256) + $byte;
            }
        }

        $mask = $masked ? $this->readExact(4) : null;
        $payload = $this->readExact($length);

        if (null !== $mask) {
            $payload = $this->mask($payload, $mask);
        }

        if (0x8 === $opcode) {
            $this->closed = true;

            return;
        }

        if (0x9 === $opcode) {
            $this->writeFrame(0xA, $payload);

            return;
        }

        if ( ! in_array($opcode, [0x0, 0x1, 0x2, 0xA], true)) {
            throw new InvalidResponseException('Docker WebSocket frame uses an unsupported opcode.');
        }

        if (0xA !== $opcode) {
            $this->buffer .= $payload;
        }
    }

    private function writeFrame(int $opcode, string $payload): void
    {
        $length = mb_strlen($payload, '8bit');
        $header = chr(0x80 | $opcode);

        if ($length < 126) {
            $header .= chr(0x80 | $length);
        } elseif ($length <= 0xffff) {
            $header .= chr(0x80 | 126) . pack('n', $length);
        } else {
            $header .= chr(0x80 | 127) . pack('NN', intdiv($length, 0x100000000), $length & 0xffffffff);
        }

        $mask = random_bytes(4);
        $this->writeAll($header . $mask . $this->mask($payload, $mask));
    }

    private function mask(string $payload, string $mask): string
    {
        $result = '';

        for ($index = 0, $length = mb_strlen($payload, '8bit'); $index < $length; $index++) {
            $result .= $payload[$index] ^ $mask[$index % 4];
        }

        return $result;
    }

    private function readExact(int $length): string
    {
        $value = '';

        while (mb_strlen($value, '8bit') < $length && ! $this->inner->eof()) {
            $value .= $this->inner->read($length - mb_strlen($value, '8bit'));
        }

        if (mb_strlen($value, '8bit') !== $length) {
            throw new InvalidResponseException('Docker WebSocket stream ended inside a frame.');
        }

        return $value;
    }

    private function writeAll(string $data): void
    {
        $offset = 0;

        while ($offset < mb_strlen($data, '8bit')) {
            $written = $this->inner->write(mb_substr($data, $offset, null, '8bit'));

            if (0 === $written) {
                throw new InvalidResponseException('Docker WebSocket stream could not write a frame.');
            }

            $offset += $written;
        }
    }
}
