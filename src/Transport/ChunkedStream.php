<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Transport;

use Misaf\DockerEngine\Contracts\Stream;
use Misaf\DockerEngine\Exceptions\InvalidResponseException;

final class ChunkedStream implements Stream
{
    private int $remaining = 0;

    private bool $finished = false;

    public function __construct(private readonly Stream $inner) {}

    public function read(int $length = 8192): string
    {
        if ($this->finished) {
            return '';
        }

        if (0 === $this->remaining) {
            $line = $this->line();
            $token = mb_trim(strtok($line, ';') ?: $line);

            if (1 !== preg_match('/^[0-9a-fA-F]+$/', $token)) {
                throw new InvalidResponseException('Docker chunked response contains an invalid chunk size.');
            }

            $size = (int) hexdec($token);

            if (0 === $size) {
                $this->finished = true;
                $this->consumeTrailers();

                return '';
            }

            $this->remaining = $size;
        }

        $chunk = $this->inner->read(min(max(1, $length), $this->remaining));

        if ('' === $chunk && $this->inner->eof()) {
            throw new InvalidResponseException('Docker chunked response ended inside a chunk.');
        }

        $this->remaining -= mb_strlen($chunk, '8bit');

        if (0 === $this->remaining) {
            $ending = $this->readExact(2);

            if ("\r\n" !== $ending) {
                throw new InvalidResponseException('Docker chunked response has an invalid chunk terminator.');
            }
        }

        return $chunk;
    }

    public function write(string $data): int
    {
        return $this->inner->write($data);
    }

    public function eof(): bool
    {
        return $this->finished;
    }

    public function close(): void
    {
        $this->inner->close();
    }

    private function line(): string
    {
        $line = '';

        while ( ! str_ends_with($line, "\r\n") && ! $this->inner->eof()) {
            $line .= $this->inner->read(1);
        }

        if ( ! str_ends_with($line, "\r\n")) {
            throw new InvalidResponseException('Docker chunked response ended while reading a chunk size.');
        }

        return mb_substr($line, 0, -2, '8bit');
    }

    private function readExact(int $length): string
    {
        $value = '';

        while (mb_strlen($value, '8bit') < $length && ! $this->inner->eof()) {
            $value .= $this->inner->read($length - mb_strlen($value, '8bit'));
        }

        return $value;
    }

    private function consumeTrailers(): void
    {
        do {
            $line = $this->line();
        } while ('' !== $line);
    }
}
